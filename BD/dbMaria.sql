use dbknapsak9;

-- make sell / use item pas possible si reste juste 1

-- Drop tables if they exist
drop table if exists cart cascade;
drop table if exists inventaire cascade;
drop table if exists shop cascade;
drop table if exists Arme cascade;
drop table if exists Armure cascade;
drop table if exists Medicaments cascade;
drop table if exists Nourriture cascade;
drop table if exists Munition cascade;
drop table if exists commentaires cascade;
drop table if exists evaluations cascade;
drop table if exists reponsesQuetes cascade;
drop table if exists listeQuetes cascade;
drop table if exists diffQuetes cascade;
drop table if exists item cascade;
drop table if exists responseStreak cascade;
drop table if exists playerQuests cascade;
drop table if exists joueure cascade;

-- [ tables ] --

-- [ joueure ] -- 

create table joueure
(
    joueureID int auto_increment primary key,
    
    alias varchar(50),
    playerPassword varbinary(256) not null, -- todo
    isAdmin tinyint unsigned default 0 not null, -- 0 non, 1 oui
    nom varchar(50) not null,
    prenom varchar(50) not null,
    caps int default 1000 not null,
    dexteriter int default 100 not null,
    pv int default 100 not null,
    poidsMax int default 200 not null,
    playerImageLink varchar(300)
);

-- [ items ] --

create table item
(
    itemID int auto_increment primary key,
    itemName varchar(50) not null,
    
    description varchar(500),
    poidItem int not null,
    buyPrice int,
    sellPrice int,        -- returns error si null, si null peu pas achat/vendre donc faut griser le bouton
    imageLink varchar(100),
    utiliter tinyint unsigned default 0 not null, -- 0-255
    itemStatus tinyint unsigned default 0 not null, -- 0 = normal, 1 : inventory disabled, 2: shop diabled, 3: shop && inventory disabled 
    typeItem varchar(10),
    
    constraint ck_Item_ItemStatus check(itemStatus between 0 and 4)
);

create table cart
(
    joueureID int, 
    itemID int,
    
    primary key (joueureID, itemID),

    foreign key (itemID) references item(itemID),
    foreign key (joueureID) references joueure(joueureID),
    
    qt int not null 
);

create table inventaire
(
    joueureID int,
    itemID int,
    
    primary key (joueureID, itemID),
    
    foreign key (itemID) references item(itemID),
    foreign key (joueureID) references joueure(joueureID),

    qt int not null
);

create table shop -- un shop pour tous
(
    itemID int not null primary key,
    
    foreign key (itemID) references item(itemID),
    
    qt int -- if null => infini
);

-- item types

create table Arme
(
    itemID int not null primary key,
    
    foreign key (itemID) references item(itemID),
    
    efficiency varchar(50),
    genre varchar(50),
    calibre varchar(50)
);

create table Armure
(
    itemID int not null primary key,
    
    foreign key (itemID) references item(itemID),
    
    material varchar(50),
    size varchar(50)
);

create table Medicaments
(
    itemID int not null primary key,
    
    foreign key (itemID) references item(itemID),
    
    healthGain int not null default 0,
    effect varchar(50),
    duration varchar(50),
    unwantedEffect varchar(50)
);

create table Nourriture
(
    itemID int not null primary key,
    
    foreign key (itemID) references item(itemID),

    healthGain int not null default 0,
    apportCalorique varchar(50),
    composantNutritivePrincipale varchar(50),
    mineralPrincipale varchar(50)
);

create table Munition
(
    itemID int not null primary key,
    
    foreign key (itemID) references item(itemID),
    
    calibre varchar(50)
);

--

create table commentaires
(
    itemID int,
    joueureID int,
    commentaireID int auto_increment,
    
    foreign key (itemID) references item(itemID),
    foreign key (joueureID) references joueure(joueureID),
    primary key (commentaireID),

    commentaire varchar(1200),
    evaluations smallint,  -- entre 1 et 5
    
    constraint ck_Commentaire_Evaluation check(evaluations between 1 and 5)
);

--[ DEPRICATED ]--
create table evaluations
(
    itemID int,
    joueureID int,

    foreign key (itemID) references item(itemID),
    foreign key (joueureID) references joueure(joueureID),
    primary key (itemID, joueureID),

    evaluations smallint,  -- entre 1 et 10
    
    constraint ck_Commentaire_Evaluation check(evaluations between 1 and 10)    
);

-- [ quetes ] --

create table diffQuetes
(
    diffID int not null primary key,
    difficultyName varchar(20) not null,
    pvLoss int not null,

    nbCaps int not null
);

create table listeQuetes
(
    -- todo add loss life
    questID int auto_increment primary key,
    diffID int not null,
    
    foreign key (diffID) references diffQuetes(diffID),
    
    question varchar(200) not null
);

create table reponsesQuetes
(
    awnserID int auto_increment primary key,
    questID int not null,

    foreign key (questID) references listeQuetes(questID),
    
    reponse varchar(200) not null,
    flagEstVrai smallint not null default 0,
    
    constraint ck_reponsesQuetes_flagEstVrai check(flagEstVrai between 0 and 1) -- stay entre 0 et 1 pour le flag 0=> false
);

create table responseStreak
(
    joueureID int primary key,

    streak int not null default 0,

    foreign key (joueureID) references joueure(joueureID)
);

create table playerQuests
(
    joueureID int not null,
    questID int not null,

    foreign key (questID) references listeQuetes(questID),
    foreign key (joueureID) references joueure(joueureID),
    primary key (joueureID, questID)
);

-- player last time --

create table lastTimeTable
(
	playerID int not null,
    
    foreign key (playerID) references joueure(joueureID),
    
	lastTime int
)

-- [  VIEWS  ] --

-- removed les view pcq sa aide pas pis sa add du clutter pour a rien

-- shop
drop view if exists ShopPreview; -- preview info for shop
-- create view ShopPreview as
-- select itemName, poidItem, imageLink, buyPrice 
-- from shop
-- join item
-- on shop.itemID = item.itemID;

drop view if exists ShopView;   -- all main info for all items in shop, but not the details ==> use la procedure stoquer pour
-- create view ShopView as
-- select shop.itemID, itemName, poidItem, utiliter, imageLink, buyPrice, qt 
-- from shop
-- join item
-- on shop.itemID = item.itemID;

-- cart
drop view if exists CartPreview; -- preview info for cart
-- create view CartPreview as
-- select itemName, poidItem, imageLink, buyPrice 
-- from cart
-- join item
-- on cart.itemID = item.itemID;

drop view if exists CartItems;   -- all main info for all items in cart, but not the details ==> use la procedure stoquer pour
-- create view CartItems as
-- select itemName, poidItem, utiliter, imageLink, buyPrice, qt 
-- from shop
-- join item
-- on shop.itemID = item.itemID;

-- inventaire

drop view if exists InventoryPreview;   -- preview info for inventory
-- create view InventoryPreview as
-- select itemName, poidItem, imageLink 
-- from inventaire
-- join item
-- on inventaire.itemID = item.itemID;

drop view if exists Inventory;  -- all in inventory of all joueurs
-- create view Inventory as
-- select 
--     inventaire.joueureID,
--     inventaire.itemID,
--     inventaire.qt,
--     item.itemName,
--     item.description,
--     item.poidItem,
--     item.buyPrice,
--     item.sellPrice,
--     item.imageLink,
--     item.utiliter,
--     item.itemStatus
-- from inventaire
-- join item on inventaire.itemID = item.itemID;


-- [ SELECTS ] --                just tests, utuliser 

-- Quests
select * from listeQuetes order by rand() limit 1;
select * from listeQuetes;

-- Cart
select * from cart where joueureID = 0;

-- Joueure
select * from joueure where joueureID = 0;
select caps from joueure where joueureID = 0;

-- commentaires
select * from commentaires where itemID = 0;
select avg(evaluations) as moyenne_etoiles from commentaires where itemID = 0;


-- [ PROCEDURES ] --

-- s_getItems

-- au debut ici c juste pour pouvoir voir les items de tout 

-- tous a des version one item ou multiple items, peut demander l'id du joueure concerner

-- Shop Item (One)
drop procedure if exists GetOneShopItem;
delimiter //
create procedure GetOneShopItem(in p_itemID int)
begin
    declare p_itemType varchar(10);

    select typeItem into p_itemType
    from item
    where item.itemID= p_itemID;

    -- arme armure med food mun

    if p_itemType= 'arme' then
        select * from shop
        inner join item
        on shop.itemID = item.itemID and shop.itemID= p_itemID
        inner join Arme 
        on shop.itemID = Arme.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'armure' then
        select * from shop
        inner join item
        on shop.itemID = item.itemID and shop.itemID= p_itemID
        inner join Armure
        on shop.itemID = Armure.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'med' then
        select * from shop
        inner join item
        on shop.itemID = item.itemID and shop.itemID= p_itemID
        inner join Medicaments
        on shop.itemID = Medicaments.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'food' then
        select * from shop
        inner join item
        on shop.itemID = item.itemID and shop.itemID= p_itemID
        inner join Nourriture 
        on shop.itemID = Nourriture.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'mun' then
        select * from shop
        inner join item
        on shop.itemID = item.itemID and shop.itemID= p_itemID
        inner join Munition
        on shop.itemID = Munition.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
	end if;
end;
//
delimiter ;

-- Shop Items (All)
drop procedure if exists GetAllShopItems;
delimiter //
create procedure GetAllShopItems()
begin
    select *
    from shop
    left join Arme on Arme.itemID = shop.itemID
    left join Armure on Armure.itemID = shop.itemID
    left join Medicaments on Medicaments.itemID = shop.itemID
    left join Nourriture on Nourriture.itemID = shop.itemID
    left join Munition on Munition.itemID = shop.itemID
    inner join item on item.itemID = shop.itemID;
end;
//
delimiter ;

-- Cart Item (One)
drop procedure if exists GetOneCartItem;
delimiter //
create procedure GetOneCartItem(in p_itemID int, in p_joueureID int)
begin
    declare p_itemType varchar(10);

    select typeItem into p_itemType
    from item
    where item.itemID= p_itemID;

    -- arme armure med food mun

    if p_itemType= 'arme' then
        select * from cart
        inner join item
        on cart.itemID = item.itemID and cart.itemID= p_itemID and cart.joueureID = p_joueureID
        inner join Arme 
        on cart.itemID = Arme.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'armure' then
        select * from cart
        inner join item
        on cart.itemID = item.itemID and cart.itemID= p_itemID and cart.joueureID = p_joueureID
        inner join Armure
        on cart.itemID = Armure.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'med' then
        select * from cart
        inner join item
        on cart.itemID = item.itemID and cart.itemID= p_itemID and cart.joueureID = p_joueureID
        inner join Medicaments
        on cart.itemID = Medicaments.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'food' then
        select * from cart
        inner join item
        on cart.itemID = item.itemID and cart.itemID= p_itemID and cart.joueureID = p_joueureID
        inner join Nourriture 
        on cart.itemID = Nourriture.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'mun' then
        select * from cart
        inner join item
        on cart.itemID = item.itemID and cart.itemID= p_itemID and cart.joueureID = p_joueureID
        inner join Munition
        on cart.itemID = Munition.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
	end if;
end;
//
delimiter ;

-- Cart Items (All)
drop procedure if exists GetAllCartItems;
delimiter //
create procedure GetAllCartItems(in p_joueureID int)
begin
    select *
    from cart
    left join Arme on Arme.itemID = cart.itemID
    left join Armure on Armure.itemID = cart.itemID
    left join Medicaments on Medicaments.itemID = cart.itemID
    left join Nourriture on Nourriture.itemID = cart.itemID
    left join Munition on Munition.itemID = cart.itemID
    inner join item on item.itemID = cart.itemID
    where cart.joueureID = p_joueureID;
end;
//
delimiter ;

-- Inventory Item (One)
drop procedure if exists GetOneInventoryItem;
delimiter //
create procedure GetOneInventoryItem(in p_itemID int, in p_joueureID int)
begin
    declare p_itemType varchar(10);

    select typeItem into p_itemType
    from item
    where item.itemID= p_itemID;

    -- arme armure med food mun

    if p_itemType= 'arme' then
        select * from inventaire
        inner join item
        on inventaire.itemID = item.itemID and inventaire.itemID= p_itemID and inventaire.joueureID = p_joueureID
        inner join Arme 
        on inventaire.itemID = Arme.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'armure' then
        select * from inventaire
        inner join item
        on inventaire.itemID = item.itemID and inventaire.itemID= p_itemID and inventaire.joueureID = p_joueureID
        inner join Armure
        on inventaire.itemID = Armure.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'med' then
        select * from inventaire
        inner join item
        on inventaire.itemID = item.itemID and inventaire.itemID= p_itemID and inventaire.joueureID = p_joueureID
        inner join Medicaments
        on inventaire.itemID = Medicaments.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'food' then
        select * from inventaire
        inner join item
        on inventaire.itemID = item.itemID and inventaire.itemID= p_itemID and inventaire.joueureID = p_joueureID
        inner join Nourriture 
        on inventaire.itemID = Nourriture.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'mun' then
        select * from inventaire
        inner join item
        on inventaire.itemID = item.itemID and inventaire.itemID= p_itemID and inventaire.joueureID = p_joueureID
        inner join Munition
        on inventaire.itemID = Munition.itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
	end if;
end;
//
delimiter ;

-- Inventory Items (All)
drop procedure if exists GetAllInventoryItems;
delimiter //
create procedure GetAllInventoryItems(in p_joueureID int)
begin
    select * 
    from inventaire 
    left join Arme on Arme.itemID = inventaire.itemID
    left join Armure on Armure.itemID = inventaire.itemID
    left join Medicaments on Medicaments.itemID = inventaire.itemID
    left join Nourriture on Nourriture.itemID = inventaire.itemID
    left join Munition on Munition.itemID = inventaire.itemID
    inner join item on item.itemID = inventaire.itemID
    where inventaire.joueureID = p_joueureID;
end;
//
delimiter ;

-- Item Details (One) => from item tableplutot quune table specialiser, pas trop a utuliser a par peutetre pour action admin?
drop procedure if exists GetOneItemDetails;
delimiter //
create procedure GetOneItemDetails(in p_itemID int)
begin
    declare p_itemType varchar(10);

    select typeItem into p_itemType
    from item
    where item.itemID= p_itemID;

    -- arme armure med food mun

    if p_itemType= 'arme' then
        select * from item
        inner join Arme 
        on item.itemID = Arme.itemID and item.itemID = p_itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'armure' then
        select * from item
        inner join Armure
        on item.itemID = Armure.itemID and item.itemID = p_itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'med' then
        select * from item
        inner join Medicaments
        on item.itemID = Medicaments.itemID and item.itemID = p_itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'food' then
        select * from item
        inner join Nourriture 
        on item.itemID = Nourriture.itemID and item.itemID = p_itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
    elseif p_itemType= 'mun' then
        select * from item
        inner join Munition
        on item.itemID = Munition.itemID and item.itemID = p_itemID
        where item.itemStatus= 0 or item.itemStatus= 1;
	end if;
end;
//
delimiter ;

-- Item Details (All)
drop procedure if exists GetAllItemDetails;
delimiter //
create procedure GetAllItemDetails()
begin
    select *
    from item
    left join Armure on Armure.itemID = item.itemID
    left join Medicaments on Medicaments.itemID = item.itemID
    left join Nourriture on Nourriture.itemID = item.itemID
    left join Munition on Munition.itemID = item.itemID
    left join Arme on Arme.itemID = item.itemID;
end;
//
delimiter ;

-- s_crud [ Procedures CRUD ] -- 

drop function if exists CreateJoueur;
delimiter //
create function CreateJoueur(
    p_alias varchar(50),
    p_nom varchar(50),
    p_prenom varchar(50),
    p_playerPassword varchar(50),
    p_playerImageLink varchar(300)
) returns int
begin
    declare p_playerID int;

    select joueureID into p_playerID
    from joueure
    where joueure.alias = p_alias
    limit 1;

    if p_playerID is null then
        insert into joueure (alias, nom, prenom, playerPassword, playerImageLink)
            values (p_alias, p_nom, p_prenom, SHA2(p_playerPassword, 256), p_playerImageLink); 

        select joueureID into p_playerID
        from joueure
        where joueure.alias = p_alias
        limit 1;
        return p_playerID;
    else
        signal sqlstate '45000' set message_text = 'alias deja utuliser'; -- todo check if keep
        return -1;
    end if;
end;
//
delimiter ;
drop procedure if exists ModifyUser;
delimiter //
create procedure ModifyUser(
   in p_alias varchar(50),
   in p_nom varchar(50),
   in p_prenom varchar(50),
   in p_id int
)
begin
    update joueure
    set alias = p_alias,
        nom = p_nom,
        prenom = p_prenom
    where joueureID = p_id;
end;
//
delimiter ;
drop procedure if exists SetCaps;
delimiter //
create procedure SetCaps(in p_joueureID int, in p_amount int)
begin
    update joueure set caps = p_amount where joueureID = p_joueureID;
end;
//
delimiter ;

drop procedure if exists CreateItem;
delimiter //
create procedure CreateItem(
    in p_itemName varchar(50),
    in p_description varchar(500),
    in p_poidItem int,
    in p_buyPrice int,
    in p_sellPrice int,
    in p_imageLink varchar(100),
    in p_utiliter tinyint unsigned,
    in p_itemStatus tinyint unsigned,

    in p_types varchar(10), -- => arme, armure, med, food, mun

    in p_details1 varchar(50),
    in p_details2 varchar(50),
    in p_details3 varchar(50),       -- => juste pour display de quoi dedans les classes

    in p_healthGain int,

    in p_qt int
)
begin
    declare itemID int;
    
    insert into item (itemName, description, poidItem, buyPrice, sellPrice, imageLink, utiliter, itemStatus, typeItem)
    values (p_itemName, p_description, p_poidItem, p_buyPrice, p_sellPrice, p_imageLink, p_utiliter, p_itemStatus, p_types);

    set itemID = LAST_INSERT_ID();

    if p_types = 'arme' then
        insert into Arme (itemID, efficiency, genre, calibre)
        values (itemID, p_details1, p_details2, p_details3);
    elseif p_types = 'armure' then
        insert into Armure (itemID, material, size)
        values (itemID, p_details1, p_details2);
    elseif p_types = 'med' then
        insert into Medicaments (itemID, healthGain, effect, duration, unwantedEffect)
        values (itemID, p_healthGain, p_details1, p_details2, p_details3);
    elseif p_types = 'food' then
        insert into Nourriture (itemID, healthGain, apportCalorique, composantNutritivePrincipale, mineralPrincipale)
        values (itemID, p_healthGain, p_details1, p_details2, p_details3);
    elseif p_types = 'mun' then
        insert into Munition (itemID, calibre)
        values (itemID, p_details1);
    end if;

    if p_itemStatus = 0 or p_itemStatus = 1 then -- maybe remove ? todo   ==> add to shop => peut etre dans shop, cart ou cart mais pas besoin detre nimporte ou et peu etre removed pis tout
        insert into shop(itemID, qt)
        values(itemID, p_qt);
    end if;
end;
//
delimiter ;

drop procedure if exists DeleteItemCompletely;
delimiter //
create procedure DeleteItemCompletely(in p_itemID int)
begin
    delete from item where itemID = p_itemID;

    delete from Arme where itemID = p_itemID;
    delete from Armure where itemID = p_itemID;
    delete from Medicaments where itemID = p_itemID;
    delete from Nourriture where itemID = p_itemID;
    delete from Munition where itemID = p_itemID;
end;
//
delimiter ;

-- todo -> remove from shop, cart or inventory

drop procedure if exists UseItem;
delimiter //
create procedure UseItem(in p_itemID int, in p_joueureID int) -- will remove de l'inventaire
begin
    declare p_healthGain int;
    declare itemQT int;

    select qt into itemQT
    from inventaire
    where itemID = p_itemID and joueureID = p_joueureID;

    select healthGain into p_healthGain
    from Medicaments
    where itemID = p_itemID;

    if p_healthGain is null then
        select healthGain into p_healthGain
        from Nourriture
        where itemID = p_itemID;
    end if;

    if p_healthGain is not null then
        update joueure
        set pv = pv + p_healthGain
        where joueureID = p_joueureID;

        if itemQT <= 1 then
            delete from inventaire
            where itemID = p_itemID and joueureID = p_joueureID;
        else
            update inventaire
            set qt = itemQT - 1
            where itemID = p_itemID and joueureID = p_joueureID;
        end if;
    else
        signal sqlstate '45000' set message_text = 'Item cannot be used';
    end if;
end;
//
delimiter ;

-- s_login/passwords

drop function if exists CheckLogin;
delimiter //
create function CheckLogin(p_alias varchar(50), p_playerPassword varchar(50)) returns int
begin    
    declare idJoueur int;
    
    select joueureID into idJoueur
    from joueure
    where alias = p_alias and playerPassword = SHA2(p_playerPassword, 256);
    
    if idJoueur is not null then
        return idJoueur;
    else
        return -1;
    end if;
end;
//
delimiter ;

drop procedure if exists ChangePassword;
delimiter //
create procedure ChangePassword(in p_playerID varchar(50), in p_playerPassword varchar(50))
begin
    update joueure
    set playerPassword = SHA2(p_playerPassword, 256)
    where joueureID = p_playerID;
end;
//
delimiter ;

drop function if exists AliasAvailable;
delimiter //
create function AliasAvailable(p_alias varchar(50)) returns int
begin
    declare idJoueur int;

    select joueureID into idJoueur
    from joueure
    where alias = p_alias
    limit 1;

    if idJoueur is not null then 
        return 0;
    else 
        return 1;
    end if;
end;
//
delimiter ;

-- s_commentaire Evals

-- Procedure to post a commentaire
drop procedure if exists PostCommentaire;
delimiter //
create procedure PostCommentaire(
    in p_itemID int,
    in p_joueureID int,
    in p_commentaire varchar(1200),
    in p_evaluations int
)
begin
    insert into commentaires (itemID, joueureID, commentaire, evaluations)
    values (p_itemID, p_joueureID, p_commentaire, p_evaluations);
end;
//
delimiter ;

-- Procedure to remove a commentaire
drop procedure if exists RemoveCommentaire;
delimiter //
create procedure RemoveCommentaire(
    in p_itemID int,
    in p_joueureID int,
    in p_commentaireID int
)
begin
    delete from commentaires where itemID = p_itemID and joueureID = p_joueureID and commentaireID = p_commentaireID;
end;
//
delimiter ;

-- Procedure to get all commentaires for an item
drop procedure if exists GetAllCommentaires;
delimiter //
create procedure GetAllCommentaires(
    in p_itemID int
)
begin
    select joueureID, commentaireID, commentaire
    from commentaires
    where itemID = p_itemID;
end;
//
delimiter ;

-- Procedure to modify a commentaire
drop procedure if exists ModifyCommentaire;
delimiter //
create procedure ModifyCommentaire(
    in p_itemID int,
    in p_joueureID int,
    in p_commentaireID int,
    in p_newCommentaire varchar(1200)
)
begin
    update commentaires
    set commentaire = p_newCommentaire
    where itemID = p_itemID and joueureID = p_joueureID and commentaireID = p_commentaireID;
end;
//
delimiter ;

-- Procedure to post an evaluation
drop procedure if exists PostEvaluation;
delimiter //
create procedure PostEvaluation(
    in p_itemID int,
    in p_joueureID int,
    in p_evaluation smallint
)
begin
    if p_evaluation between 1 and 10 then
        insert into evaluations (itemID, joueureID, evaluations)
        values (p_itemID, p_joueureID, p_evaluation)
        on duplicate key update evaluations = p_evaluation;
    else
        signal sqlstate '45000' set message_text = 'Evaluation must be between 1 and 10';
    end if;
end;
//
delimiter ;

-- Procedure to remove an evaluation
drop procedure if exists RemoveEvaluation;
delimiter //
create procedure RemoveEvaluation(
    in p_itemID int,
    in p_joueureID int
)
begin
    delete from evaluations where itemID = p_itemID and joueureID = p_joueureID;
end;
//
delimiter ;

-- Procedure to get all evaluations for an item
drop procedure if exists GetAllEvaluations;
delimiter //
create procedure GetAllEvaluations(
    in p_itemID int
)
begin
    select joueureID, evaluations
    from evaluations
    where itemID = p_itemID;
end;
//
delimiter ;

-- Procedure to modify an evaluation
drop procedure if exists ModifyEvaluation;
delimiter //
create procedure ModifyEvaluation(
    in p_itemID int,
    in p_joueureID int,
    in p_newEvaluation smallint
)
begin
    if p_newEvaluation between 1 and 10 then
        update evaluations
        set evaluations = p_newEvaluation
        where itemID = p_itemID and joueureID = p_joueureID;
    else
        signal sqlstate '45000' set message_text = 'Evaluation must be between 1 and 10';
    end if;
end;
//
delimiter ;

-- Procedure to get the average evaluation for an item
drop procedure if exists GetAverageEvaluation;
delimiter //
create procedure GetAverageEvaluation(
    in p_itemID int
)
begin
    select avg(evaluations) as averageEvaluation
    from evaluations
    where itemID = p_itemID;
end;
//
delimiter ;

-- s_quest
drop procedure if exists CreateQuest;
delimiter //
create procedure CreateQuest(
    in p_diffID int,
    in p_question varchar(200),
    in reponse1 varchar(200), 
    in flagEstVrai1 smallint,
    in reponse2 varchar(200), 
    in flagEstVrai2 smallint,
    in reponse3 varchar(200), 
    in flagEstVrai3 smallint,
    in reponse4 varchar(200), 
    in flagEstVrai4 smallint
)
begin
    declare questID int;
    
    insert into listeQuetes (diffID, question)
    values (p_diffID, p_question);
    
    set questID = LAST_INSERT_ID();
    
    insert into reponsesQuetes (questID, reponse, flagEstVrai)
    values 
    (questID, reponse1, flagEstVrai1),
    (questID, reponse2, flagEstVrai2),
    (questID, reponse3, flagEstVrai3),
    (questID, reponse4, flagEstVrai4);

end;
//
delimiter ;

drop procedure if exists DeleteQuest;
delimiter //
create procedure DeleteQuest(in p_questID int)
begin
    delete from reponsesQuetes where questID = p_questID;
    delete from listeQuetes where questID = p_questID;
end;
//
delimiter ;

-- unsure wtf that is, duplicate??

-- drop function if exists DoQuest; -- utiliser pour checker si la reponse est la bonne et donner les caps
-- delimiter //
-- create function DoQuest(
--     p_questID int,
--     p_joueureID int,
--     p_answerID int
-- ) returns int
-- begin
--     declare correctAnswerExists boolean;
--     declare reward int;
--     declare healthLoss int;

--     select exists (
--         select 1 
--         from reponsesQuetes 
--         where questID = p_questID and awnserID = p_answerID and flagEstVrai = 1
--     ) into correctAnswerExists;

--     if correctAnswerExists then
--         select dq.nbCaps into reward
--         from listeQuetes lq
--         join diffQuetes dq on lq.diffID = dq.diffID
--         where lq.questID = questID;

--         set reward = reward + 
--             case 
--                 when (select streak from responseStreak where joueureID = p_joueureID) % 3 = 0 then 1000
--                 else 0
--             end;

--         update joueure
--         set caps = caps + reward
--         where joueureID= p_joueureID;

--         update responseStreak
--         set streak= streak + 1
--         where joueureID= p_joueureID;

--         delete from playerQuests 
--         where joueureID= p_joueureID;

--         return 1;
--     else
--         select dq.pvLoss into healthLoss
--         from listeQuetes lq
--         join diffQuetes dq on lq.diffID = dq.diffID
--         where lq.questID= p_questID;
        
--         update joueure
--         set pv = pv - healthLoss
--         where joueureID= p_joueureID;

--         update responseStreak
--         set streak= 0
--         where joueureID= p_joueureID;
        
--         delete from playerQuests 
--         where joueureID= p_joueureID;

--         if (select pv from joueure where joueureID= p_joueureID) <= 0 then
--             return 2;
--         end if;

--         return 0;
--     end if;
--     signal sqlstate '45000' set message_text = 'func not used properly, use a select';
-- end;
-- //
-- delimiter ;

-- get one random by diff
-- get one by id
-- get all

-- get one random
drop procedure if exists GetOneRandomQuestionByDifficulty;
delimiter //
create procedure GetOneRandomQuestionByDifficulty(in p_difficultyID int)
begin
    SET @row_count = (SELECT COUNT(*) FROM listeQuetes WHERE diffID = p_difficultyID);
    SET @random_offset = FLOOR(RAND() * @row_count);

    set @rnQuestID = (        
        select questID from listeQuetes
        order by rand()
        limit 1 OFFSET @random_offset; 
    )

    select listeQuetes.questID, listeQuetes.question, diffQuetes.difficultyName, diffQuetes.pvLoss from listeQuetes
    join diffQuetes on diffQuetes.diffID = listeQuetes.diffID and listeQuetes.diffID= p_difficultyID and listeQuetes.questID = @rnQuestID
    join reponsesQuetes on reponsesQuetes.questID = listeQuetes.questID
    limit 4;
end;
//
delimiter ;

drop function if exists DoQuest;
delimiter //
create function DoQuest(
    p_questID int,
    p_joueureID int,
    p_answerID int
) returns int
begin
    declare correctAnswerExists boolean;
    declare reward int;
    declare healthLoss int;

    select exists (
        select 1 
        from reponsesQuetes 
        where questID = p_questID and awnserID = p_answerID and flagEstVrai = 1
        limit 1
    ) into correctAnswerExists;

    if correctAnswerExists then
        select dq.nbCaps into reward
        from listeQuetes lq
        join diffQuetes dq on lq.diffID = dq.diffID
        where lq.questID = p_questID
        limit 1;

        if exists (select 1 from responseStreak where joueureID = p_joueureID) then
            update responseStreak
            set streak = streak + 1
            where joueureID = p_joueureID;
        else
            insert into responseStreak (joueureID, streak)
            values (p_joueureID, 1);
        end if;

        set reward = reward + 
            case 
                when (select streak from responseStreak where joueureID = p_joueureID) % 3 = 0 then 1000
                else 0
            end;

        update joueure
        set caps = caps + reward
        where joueureID = p_joueureID;

        delete from playerQuests 
        where joueureID = p_joueureID;

        return 1; -- Success
    else
        select dq.pvLoss into healthLoss
        from listeQuetes lq
        join diffQuetes dq on lq.diffID = dq.diffID
        where lq.questID = p_questID
        limit 1;

        update joueure
        set pv = pv - healthLoss
        where joueureID = p_joueureID;

        if exists (select 1 from responseStreak where joueureID = p_joueureID) then
            update responseStreak
            set streak = 0
            where joueureID = p_joueureID;
        else
            insert into responseStreak (joueureID, streak)
            values (p_joueureID, 0);
        end if;

        delete from playerQuests 
        where joueureID = p_joueureID;

        if (select pv from joueure where joueureID = p_joueureID) <= 0 then
            return 2; -- Player dead
        end if;

        return 0; -- Incorrect answer
    end if;
end;
//
delimiter ;

-- get all
drop procedure if exists GetAllQuestionsAndAwnser;
delimiter //
create procedure GetAllQuestionsAndAwnser()
begin
    select listeQuetes.questID, listeQuetes.question, reponsesQuetes.reponse, diffQuetes.difficultyName,reponsesQuetes.awnserID, diffQuetes.pvLoss, reponsesQuetes.flagEstVrai from listeQuetes
    join diffQuetes on diffQuetes.diffID = listeQuetes.diffID
    join reponsesQuetes on reponsesQuetes.questID = listeQuetes.questID;
end;
//
delimiter ;

-- s_cart

drop procedure if exists AddItemToCart;
delimiter //
create procedure AddItemToCart(
    in p_joueureID int,
    in p_itemID int,
    in p_quantity int
)
begin
    declare stock_disponible int default 0;
    declare cart_quantity int default 0;
    declare item_status tinyint default 0;

    start transaction;

    -- Verifie l'etat de l'item
    select itemStatus into item_status
    from item
    where itemID = p_itemID;

    -- Verifie la quantite disponible dans le shop
    select coalesce(qt, 0) into stock_disponible
    from shop
    where itemID = p_itemID;

    -- Verifie la quantite actuelle dans le panier
    select coalesce(qt, 0) into cart_quantity
    from cart
    where joueureID = p_joueureID and itemID = p_itemID;

    -- Verifie si l'item est interdit à la vente
    if item_status in (2,3) then
        signal sqlstate '45000' set message_text = 'Cet item ne peut pas etre achete.';
    end if;

    -- Si on veut ajouter des items
    if p_quantity > 0 then
        if stock_disponible >= p_quantity then
            if cart_quantity > 0 then
                update cart
                set qt = qt + p_quantity
                where joueureID = p_joueureID and itemID = p_itemID;
            else
                insert into cart (joueureID, itemID, qt)
                values (p_joueureID, p_itemID, p_quantity);
            end if;
            
            -- Retirer du shop
            update shop
            set qt = qt - p_quantity
            where itemID = p_itemID;

            -- Si stock shop = 0, supprimer l'item du shop
            delete from shop where itemID = p_itemID and qt <= 0;
        else
            signal sqlstate '45000' set message_text = 'Stock insuffisant dans le shop';
        end if;
    
    -- Si on veut retirer des items (p_quantity < 0)
    elseif p_quantity < 0 then
        if cart_quantity > 0 then
            if cart_quantity + p_quantity <= 0 then
                -- Supprimer complètement l'item du panier
                delete from cart where joueureID = p_joueureID and itemID = p_itemID;
                
                -- Remettre les items retires dans le shop
                if exists (select 1 from shop where itemID = p_itemID) then
                    update shop
                    set qt = qt + cart_quantity
                    where itemID = p_itemID;
                else
                    insert into shop (itemID, qt)
                    values (p_itemID, cart_quantity);
                end if;
            else
                -- Sinon, juste reduire la quantite
                update cart
                set qt = qt + p_quantity
                where joueureID = p_joueureID and itemID = p_itemID;
                
                -- Remettre les items retires dans le shop
                if exists (select 1 from shop where itemID = p_itemID) then
                    update shop
                    set qt = qt - p_quantity
                    where itemID = p_itemID;
                else
                    insert into shop (itemID, qt)
                    values (p_itemID, -p_quantity);
                end if;
            end if;
        end if;
    end if;

    commit;
end;
//
delimiter ;


drop procedure if exists PassCommande;
delimiter //
create procedure PassCommande(
    in p_joueureID int
)
begin
    declare totalCost decimal(10,2) default 0;
    
    start transaction;
    -- Calcul cout 
    select coalesce(sum(c.qt * i.buyPrice), 0) into totalCost
    from cart c
    join item i on c.itemID = i.itemID
    where c.joueureID = p_joueureID;
    
    if totalCost > 0 and exists (select 1 from joueure where joueureID = p_joueureID and caps >= totalCost) then
        
        update joueure
        set caps = caps - totalCost
        where joueureID = p_joueureID;
        
        insert into inventaire (joueureID, itemID, qt)
        select c.joueureID, c.itemID, c.qt from cart c
        where c.joueureID = p_joueureID
        on duplicate key update qt = inventaire.qt + c.qt;
        
        delete from cart where joueureID = p_joueureID;
        
    else
        rollback;
        signal sqlstate '45000' set message_text = 'Fonds insuffisants ou panier vide';
    end if;

    commit;
end;
//
delimiter ;


-- remove pour toujour cet item du cart -> remet dans le shop
drop procedure if exists RemoveItemFromCart;
delimiter //
create procedure RemoveItemFromCart(
    in p_joueureID int,
    in p_itemID int
)
begin
    declare v_qt int;

    start transaction;

    select qt into v_qt from cart where joueureID = p_joueureID and itemID = p_itemID;

    delete from cart where joueureID = p_joueureID and itemID = p_itemID;

    insert into shop (itemID, qt) 
    values (p_itemID, v_qt)
    on duplicate key update qt = qt + v_qt;

    commit;
end;
//
delimiter ;

drop procedure if exists ClearCart;
delimiter //
create procedure ClearCart(
    in p_joueureID int
)
begin
    start transaction;

    insert into shop (itemID, qt)
    select itemID, qt from cart where joueureID = p_joueureID
    on duplicate key update shop.qt = shop.qt + cart.qt;

    delete from cart where joueureID = p_joueureID;

    commit;
end;
//
delimiter ;

drop procedure if exists SellItem;
delimiter //
create procedure SellItem(in p_itemID int, in p_joueureID int, in p_quantitySell int)
begin
    declare itemQT int;
    declare itemPrice int;
    declare playerBalance int;

    if p_quantitySell < 0 then 
        signal sqlstate '45000' set message_text = 'essaye de vendre une quantiter negative?';
    end if;

    select qt into itemQT
    from inventaire
    where itemID = p_itemID and joueureID = p_joueureID;

    select sellPrice into itemPrice
    from item
    where itemID = p_itemID;

    select caps into playerBalance
    from joueure
    where joueureID = p_joueureID;

    if itemQT >= p_quantitySell then
        -- sufficient quantity in inventory
        update inventaire
        set qt = itemQT - p_quantitySell
        where itemID = p_itemID and joueureID = p_joueureID;

        set playerBalance = playerBalance + (itemPrice * p_quantitySell);

        insert into shop (itemID, qt)
        values (p_itemID, p_quantitySell)
        on duplicate key update qt = qt + p_quantitySell;
    else
        -- selling more than available quantity
        delete from inventaire
        where itemID = p_itemID and joueureID = p_joueureID;

        set playerBalance = playerBalance + (itemPrice * itemQT);

        insert into shop (itemID, qt)
        values (p_itemID, itemQT)
        on duplicate key update qt = qt + itemQT;
    end if;

    update joueure
    set caps = playerBalance
    where joueureID = p_joueureID;
end;
//
delimiter ;


-- [ Triggers ] --

-- Trigger pour la table Arme
delimiter //
create trigger before_insert_Arme
before insert on Arme
for each row
begin
    if exists (select 1 from Armure where itemID = NEW.itemID) or
       exists (select 1 from Medicaments where itemID = NEW.itemID) or
       exists (select 1 from Nourriture where itemID = NEW.itemID) or
       exists (select 1 from Munition where itemID = NEW.itemID) then
        signal sqlstate '45000' set message_text = 'Item already exists in another type table';
    end if;
end;
//
delimiter ;

-- Trigger pour la table Armure
delimiter //
create trigger before_insert_Armure
before insert on Armure
for each row
begin
    if exists (select 1 from Arme where itemID = NEW.itemID) or
       exists (select 1 from Medicaments where itemID = NEW.itemID) or
       exists (select 1 from Nourriture where itemID = NEW.itemID) or
       exists (select 1 from Munition where itemID = NEW.itemID) then
        signal sqlstate '45000' set message_text = 'Item a deja un type, faite pas sa, pour creer un item il faut utuliser la procedure stoquer';
    end if;
end;
//
delimiter ;

-- Trigger pour la table Medicaments
delimiter //
create trigger before_insert_Medicaments
before insert on Medicaments
for each row
begin
    if exists (select 1 from Arme where itemID = NEW.itemID) or
       exists (select 1 from Armure where itemID = NEW.itemID) or
       exists (select 1 from Nourriture where itemID = NEW.itemID) or
       exists (select 1 from Munition where itemID = NEW.itemID) then
        signal sqlstate '45000' set message_text = 'Item a deja un type, faite pas sa, pour creer un item il faut utuliser la procedure stoquer';
    end if;
end;
//
delimiter ;

-- Trigger pour la table Nourriture
delimiter //
create trigger before_insert_Nourriture
before insert on Nourriture
for each row
begin
    if exists (select 1 from Arme where itemID = NEW.itemID) or
       exists (select 1 from Armure where itemID = NEW.itemID) or
       exists (select 1 from Medicaments where itemID = NEW.itemID) or
       exists (select 1 from Munition where itemID = NEW.itemID) then
        signal sqlstate '45000' set message_text = 'Item a deja un type, faite pas sa, pour creer un item il faut utuliser la procedure stoquer';
    end if;
end;
//
delimiter ;

-- Trigger pour la table Munition
delimiter //
create trigger before_insert_Munition
before insert on Munition
for each row
begin
    if exists (select 1 from Arme where itemID = NEW.itemID) or
       exists (select 1 from Armure where itemID = NEW.itemID) or
       exists (select 1 from Medicaments where itemID = NEW.itemID) or
       exists (select 1 from Nourriture where itemID = NEW.itemID) then
        signal sqlstate '45000' set message_text = 'Item a deja un type, faite pas sa, pour creer un item il faut utuliser la procedure stoquer';
    end if;
end;
//
delimiter ;

-- [ DEFAULT DATA ] --

-- Difficultes des quetes
insert into diffQuetes (diffID, difficultyName, pvLoss, nbCaps) values (1, 'facile', 10, 50), (2, 'moyen', 20, 100), (3, 'difficile', 40, 200);

-- Creation de quetes
call CreateQuest(1, 'Quelle est la couleur du ciel ?', 'Bleu', 1, 'Vert', 0, 'Rouge', 0, 'Jaune', 0);
call CreateQuest(1, 'Combien de pattes a un chien ?', '2', 0, '4', 1, '6', 0, '8', 0);
call CreateQuest(1, 'Quelle est la capitale de la France ?', 'Berlin', 0, 'Madrid', 0, 'Paris', 1, 'Rome', 0);
call CreateQuest(1, 'Combien font 2 + 2 ?', '3', 0, '4', 1, '5', 0, '6', 0);
call CreateQuest(1, 'Quel est le plus grand ocean ?', 'Atlantique', 0, 'Pacifique', 1, 'Arctique', 0, 'Indien', 0);
call CreateQuest(1, 'Quelle est la planète la plus proche du soleil ?', 'Mars', 0, 'Mercure', 1, 'Venus', 0, 'Terre', 0);
call CreateQuest(2, 'Combien y a-t-il de continents ?', '5', 0, '6', 0, '7', 1, '8', 0);
call CreateQuest(2, 'Quel est le plus grand desert du monde ?', 'Sahara', 1, 'Gobi', 0, 'Kalahari', 0, 'Arctique', 0);
call CreateQuest(2, 'Quel est le symbole chimique de l’eau ?', 'H2O', 1, 'O2', 0, 'CO2', 0, 'H2', 0);
call CreateQuest(2, 'Quel est le plus haut sommet du monde ?', 'Mont Blanc', 0, 'Everest', 1, 'Kilimandjaro', 0, 'Aconcagua', 0);
call CreateQuest(2, 'Quel est l’animal terrestre le plus rapide ?', 'Guepard', 1, 'Lion', 0, 'Antilope', 0, 'Tigre', 0);
call CreateQuest(2, 'Combien de jours y a-t-il dans une annee bissextile ?', '364', 0, '365', 0, '366', 1, '367', 0);
call CreateQuest(3, 'Quel est le plus grand pays du monde ?', 'Canada', 0, 'Russie', 1, 'Chine', 0, 'etats-Unis', 0);
call CreateQuest(3, 'Quel est l’element chimique le plus leger ?', 'Helium', 0, 'Hydrogène', 1, 'Oxygène', 0, 'Azote', 0);
call CreateQuest(3, 'Quel est le plus grand mammifère marin ?', 'Orque', 0, 'Baleine bleue', 1, 'Dauphin', 0, 'Requin', 0);
call CreateQuest(3, 'Quel est le plus long fleuve du monde ?', 'Nil', 1, 'Amazonie', 0, 'Yangtse', 0, 'Mississippi', 0);
call CreateQuest(3, 'Quel est le plus petit os du corps humain ?', 'Femur', 0, 'etrier', 1, 'Tibia', 0, 'Radius', 0);
call CreateQuest(3, 'Quel est le plus grand organe du corps humain ?', 'Cœur', 0, 'Peau', 1, 'Foie', 0, 'Poumon', 0);
call CreateQuest(3, 'Quel est le plus grand lac d’eau douce du monde ?', 'Lac Victoria', 0, 'Lac Superieur', 1, 'Lac Baïkal', 0, 'Lac Tanganyika', 0);
call CreateQuest(3, 'Quel est le plus grand volcan actif du monde ?', 'Etna', 0, 'Mauna Loa', 1, 'Kilimandjaro', 0, 'Vesuve', 0);
call CreateQuest(3, 'Quel est le plus grand desert chaud du monde ?', 'Sahara', 1, 'Gobi', 0, 'Kalahari', 0, 'Atacama', 0);
call CreateQuest(3, 'Quel est le plus grand recif corallien du monde ?', 'Recif de Belize', 0, 'Grande Barrière de Corail', 1, 'Recif de Floride', 0, 'Recif de Palancar', 0);
call CreateQuest(3, 'Quel est le plus grand arbre du monde ?', 'Sequoia', 1, 'Chene', 0, 'Baobab', 0, 'erable', 0);
call CreateQuest(3, 'Quel est le plus grand oiseau du monde ?', 'Aigle', 0, 'Autruche', 1, 'Condor', 0, 'Albatros', 0);
call CreateQuest(3, 'Quel est le plus grand reptile du monde ?', 'Crocodile', 1, 'Serpent', 0, 'Tortue', 0, 'Iguane', 0);
call CreateQuest(3, 'Quel est le plus grand poisson du monde ?', 'Requin blanc', 0, 'Requin-baleine', 1, 'Espadon', 0, 'Thon', 0);
call CreateQuest(3, 'Quel est le plus grand amphibiens du monde ?', 'Grenouille', 0, 'Salamandre geante', 1, 'Triton', 0, 'Crapaud', 0);
call CreateQuest(3, 'Quel est le plus grand insecte du monde ?', 'Fourmi', 0, 'Phasme', 1, 'Scarabee', 0, 'Papillon', 0);
call CreateQuest(3, 'Quel est le plus grand oiseau volant du monde ?', 'Condor', 1, 'Aigle', 0, 'Autruche', 0, 'Albatros', 0);
call CreateQuest(3, 'Quel est le plus grand predateur terrestre ?', 'Lion', 0, 'Ours polaire', 1, 'Tigre', 0, 'Loup', 0);

-- extra quests
-- https://thepleasantconversation.com/trivia-questions/

call CreateQuest(1, 'Dans quel pays se trouve l’aéroport Charles de Gaulle ?', 'Paris, France', 1, 'Rome, Italie', 0, 'Berlin, Allemagne', 0, 'Madrid, Espagne', 0);
call CreateQuest(1, 'Qui fut le premier homme sur Terre ?', 'Moïse', 0, 'Adam', 1, 'Noé', 0, 'Abraham', 0);
call CreateQuest(1, 'Quelle est la signification de "www" ?', 'Wide Web World', 0, 'World Web Wide', 0, 'World Wide Web', 1, 'Web World Wide', 0);
call CreateQuest(2, 'Qui a peint le célèbre portrait "La Joconde" ?', 'Claude Monet', 0, 'Pablo Picasso', 0, 'Vincent van Gogh', 0, 'Leonard de Vinci', 1);
call CreateQuest(2, 'Quels sont les deux États américains qui n\'observent pas l\'heure d\'été ?', 'Hawaii et Arizona', 1, 'Californie et Texas', 0, 'Floride et Alaska', 0, 'New York et Nevada', 0);
call CreateQuest(1, 'Qui fut le premier président des États-Unis ?', 'George Washington', 1, 'Thomas Jefferson', 0, 'Abraham Lincoln', 0, 'John Adams', 0);
call CreateQuest(1, 'Qui était Wolfgang Amadeus Mozart ?', 'Peintre', 0, 'Philosophe', 0, 'Compositeur de musique', 1, 'Scientifique', 0);
call CreateQuest(2, 'En quelle année a commencé la Première Guerre mondiale ?', '1914', 1, '1918', 0, '1939', 0, '1905', 0);
call CreateQuest(2, 'Quelle est la taille d\'un terrain de cricket ?', '18 yards', 0, '20 mètres', 0, '22 yards', 1, '25 mètres', 0);
call CreateQuest(2, 'Quel est le lieu de naissance de William Shakespeare ?', 'Londres', 0, 'Oxford', 0, 'Cambridge', 0, 'Stratford-upon-Avon, Royaume-Uni', 1);

call CreateQuest(2, 'Où John Lennon a-t-il été abattu ?', 'The Dakota, New York', 1, 'Central Park, New York', 0, 'Abbey Road, Londres', 0, 'Hollywood Boulevard, Los Angeles', 0);
call CreateQuest(2, 'Qui a écrit le célèbre poème "The road not taken" ?', 'Ernest Hemingway', 0, 'Robert Frost', 1, 'Mark Twain', 0, 'Emily Dickinson', 0);
call CreateQuest(1, 'Quel est le plus haut bâtiment du monde ?', 'Burj Khalifa, Dubaï', 0, 'Shanghai Tower, Chine', 0, 'Abraj Al-Bait, Arabie Saoudite', 0, 'Burj Khalifa, Dubaï', 1);
call CreateQuest(3, 'Qui fut la première championne olympique ?', 'Marie Curie', 0, 'Hélène de Pourtalès', 0, 'Florence Griffith-Joyner', 0, 'Helene de Pourtales', 1);
call CreateQuest(2, 'Quel est le lac le plus profond du monde ?', 'Lac Victoria, Afrique', 0, 'Lac Tanganyika, Afrique', 0, 'Lac Supérieur, Canada', 0, 'Lac Baïkal, Sibérie', 1);
call CreateQuest(1, 'Pourquoi Times Square est-il célèbre ?', 'Pour ses parcs naturels', 0, 'Pour ses monuments historiques', 0, 'Pour ses pubs, restaurants, théâtres', 1, 'Pour ses plages', 0);
call CreateQuest(2, 'Quelle fut la dernière pièce de théâtre de William Shakespeare ?', 'Hamlet', 0, 'Roméo et Juliette', 0, 'Le Roi Lear', 0, 'La Tempête', 1);
call CreateQuest(3, 'Comment appelle-t-on l\'étude des œufs d\'oiseaux ?', 'Ichtyologie', 0, 'Ornithologie', 0, 'Entomologie', 0, 'Oologie', 1);
call CreateQuest(2, 'D\'où provient le café moka ?', 'Colombie', 0, 'Éthiopie', 0, 'Brésil', 0, 'Yémen', 1);
call CreateQuest(1, 'Quel jouet a été utilisé pour nettoyer les papiers peints ?', 'Slime', 0, 'Argile', 0, 'Pâte à modeler', 1, 'Craie', 0);

call CreateQuest(1, 'Quel jouet est utilisé pour nettoyer les papiers peints ?', 'Pâte à modeler', 1, 'Argile', 0, 'Slime', 0, 'Craie', 0);
call CreateQuest(1, 'Quel accessoire informatique est aussi un animal ?', 'Clavier', 0, 'Souris', 1, 'Écran', 0, 'Tablette', 0);
call CreateQuest(3, 'Connaissez-vous la plus vieille ville du monde ? Quelle est-elle ?', 'Damas, Syrie', 0, 'Aleppo, Syrie', 1, 'Babylon, Irak', 0, 'Athènes, Grèce', 0);
call CreateQuest(2, 'Quel État des États-Unis a une devise en espagnol ?', 'New Mexico', 0, 'Arizona', 0, 'Montana', 1, 'Texas', 0);
call CreateQuest(3, 'Combien de récepteurs sensoriels y a-t-il dans le nez d\'un chien ?', '200 millions', 0, '400 millions', 0, '300 millions… incroyable', 1, '500 millions', 0);
call CreateQuest(2, 'Nommer un poisson venimeux ?', 'Poisson-clown', 0, 'Poisson-lion', 0, 'Poisson-pierre', 1, 'Raie manta', 0);
call CreateQuest(3, 'Où se situe la plus vieille bibliothèque du monde ?', 'Bibliothèque nationale de France', 0, 'Bibliothèque d’Alexandrie', 0, 'Bibliothèque Al-Qarawiyyin à Fès, Maroc', 1, 'Bibliothèque du Vatican', 0);
call CreateQuest(2, 'Quel est le plus grand aéroport des États-Unis ?', 'Aéroport international de Los Angeles, Californie', 0, 'Aéroport de Chicago O\'Hare, Illinois', 0, 'Aéroport international de Denver, Colorado', 1, 'Aéroport international de Miami, Floride', 0);
call CreateQuest(1, 'Quel est le plus grand producteur de chocolat au monde ?', 'Belgique', 0, 'Suisse', 0, 'Côte d\'Ivoire', 1, 'Brésil', 0);
call CreateQuest(1, 'Quel pays partage une frontière avec les États-Unis ?', 'Mexique', 0, 'Canada', 1, 'Cuba', 0, 'Guatemala', 0);
call CreateQuest(3, 'Quel est le plus petit animal sur cette planète ?', 'Paedophryne amauensis', 1, 'Colibri', 0, 'Moustique', 0, 'Souris', 0);
call CreateQuest(1, 'Quel est le sport le plus célèbre au monde ?', 'Football', 1, 'Basketball', 0, 'Cricket', 0, 'Tennis', 0);
call CreateQuest(2, 'Nommer un animal connu pour son son le plus fort ?', 'Éléphant', 0, 'Cachalot', 1, 'Lion', 0, 'Dauphin', 0);
call CreateQuest(1, 'Où trouve-t-on les pyramides de Gizeh ?', 'Égypte', 1, 'Irak', 0, 'Grèce', 0, 'Syrie', 0);
call CreateQuest(2, 'Quels sont les planètes du système solaire qui n\'ont pas de lunes ?', 'Mars et Jupiter', 0, 'Vénus et Mercure', 1, 'Terre et Saturne', 0, 'Uranus et Neptune', 0);
call CreateQuest(3, 'Quel est le plus grand glacier connu dans l\'histoire ?', 'Glacier de Perito Moreno, Argentine', 0, 'Glacier de Lambert-Fisher, Antarctique', 1, 'Glacier de Vatnajökull, Islande', 0, 'Glacier de Jostedalsbreen, Norvège', 0);
call CreateQuest(1, 'Qui a découvert l\'ADN ?', 'Louis Pasteur', 0, 'Friedrich Miescher', 1, 'Marie Curie', 0, 'Albert Einstein', 0);
call CreateQuest(2, 'Quel est le premier film d\'animation nommé aux Oscars pour la catégorie meilleur film ?', 'Le Roi Lion', 0, 'La Belle et la Bête', 1, 'Toy Story', 0, 'Shrek', 0);
call CreateQuest(1, 'Combien de cellules y a-t-il dans le corps humain ?', '37.2 trillions', 1, '50 trillions', 0, '100 trillions', 0, '10 trillions', 0);
call CreateQuest(3, 'Quel est le plus grand comté du Royaume-Uni ?', 'Cornouailles', 0, 'North Yorkshire', 1, 'West Midlands', 0, 'Londres', 0);

call CreateQuest(3, 'Quelle est la plus grande constitution écrite du monde ?', 'La Constitution de l\'Inde', 1, 'La Constitution des États-Unis', 0, 'La Constitution de la France', 0, 'La Constitution du Japon', 0);
call CreateQuest(2, 'Quel est le plus long fleuve du monde ?', 'L\'Amazonie', 0, 'Le Nil', 1, 'Le Mississippi', 0, 'Le Yangzi', 0);
call CreateQuest(1, 'Comment appelle-t-on les bébés chevaux ?', 'Poulain', 1, 'Veau', 0, 'Agneau', 0, 'Calf', 0);
call CreateQuest(2, 'Quel est le seul type de perroquet qui ne peut pas voler ?', 'Ara', 0, 'Cacatoès', 0, 'Kakapo', 1, 'Perroquet gris d\'Afrique', 0);
call CreateQuest(3, 'Quel est l\'endroit le plus sec du monde ?', 'Désert du Sahara', 0, 'Désert de Sonora', 0, 'Désert de l\'Atacama', 1, 'Désert de Kalahari', 0);
call CreateQuest(1, 'Comment s\'appelle la peur de parler en public ?', 'Nyctophobie', 0, 'Glossophobie', 1, 'Agoraphobie', 0, 'Claustrophobie', 0);
call CreateQuest(2, 'Qui a inventé le télescope ?', 'Galilée', 0, 'Hans Lipperhey', 1, 'Isaac Newton', 0, 'Johannes Kepler', 0);
call CreateQuest(2, 'Quelle est la capitale de l\'Argentine ?', 'Rio de Janeiro', 0, 'Buenos Aires', 1, 'São Paulo', 0, 'Lima', 0);
call CreateQuest(1, 'Quel pays a inventé le café ?', 'Brésil', 0, 'Éthiopie', 1, 'Colombie', 0, 'Venezuela', 0);
call CreateQuest(3, 'Quel est le lieu de naissance de Beethoven ?', 'Berlin, Allemagne', 0, 'Vienne, Autriche', 0, 'Bonn, Allemagne', 1, 'Prague, République tchèque', 0);

call CreateQuest(1, 'Quel est le cinquième signe du zodiaque ?', 'Lion', 1, 'Sagittaire', 0, 'Capricorne', 0, 'Verseau', 0);
call CreateQuest(2, 'Qui était Marco Polo ?', 'Marchand vénitien', 1, 'Explorateur espagnol', 0, 'Marchand arabe', 0, 'Explorateur italien', 0);
call CreateQuest(1, 'Quel pays consomme le plus de thé au monde ?', 'Turquie', 1, 'Chine', 0, 'Inde', 0, 'Royaume-Uni', 0);
call CreateQuest(2, 'Quelle est la langue la plus ancienne du monde ?', 'Grec ancien', 0, 'Sanskrit', 1, 'Latin', 0, 'Égyptien ancien', 0);
call CreateQuest(3, 'Pouvez-vous nommer la plus haute chute d\'eau du monde ?', 'Chutes de Niagara, Canada', 0, 'Chutes d\'Iguaçu, Brésil', 0, 'Chutes d\'Angel, Venezuela', 1, 'Chutes de Victoria, Zimbabwe', 0);
call CreateQuest(2, 'Qui a inventé le premier avion de chasse et où ?', 'Boeing, Washington', 0, 'Curtiss-Wright Corporation, Missouri', 1, 'Lockheed Martin, Californie', 0, 'Northrop Grumman, New York', 0);
call CreateQuest(1, 'Quel est le symbole chimique du mercure ?', 'Hg', 1, 'Hg2', 0, 'Me', 0, 'Mn', 0);
call CreateQuest(3, 'Dans quelle ville Jim Morrison a-t-il été enterré ?', 'Londres', 0, 'Paris', 1, 'Los Angeles', 0, 'New York', 0);
call CreateQuest(2, 'Où trouve-t-on les forêts tropicales les plus denses du monde ?', 'Indonésie', 0, 'Amazonie', 1, 'Afrique centrale', 0, 'Madagascar', 0);
call CreateQuest(1, 'Quelle est la valeur du pH de l\'eau pure ?', '5', 0, '6', 0, '7', 1, '8', 0);


call CreateQuest(3, 'Quel est le plus grand mammifère du monde ?', 'Baleine bleue', 1, 'Éléphant', 0, 'Girafe', 0, 'Rhinocéros', 0);
call CreateQuest(1, 'Comment appelle-t-on un groupe de lions ?', 'Meute', 0, 'Clan', 0, 'Fierté', 1, 'Groupe', 0);
call CreateQuest(2, 'Quel est l\'animal terrestre le plus rapide ?', 'Antilope', 0, 'Guépard', 1, 'Lion', 0, 'Tigre', 0);
call CreateQuest(2, 'En quelle année a eu lieu le premier Open d\'Australie ?', '1900', 0, '1905', 1, '1910', 0, '1920', 0);
call CreateQuest(3, 'Quelle nation a remporté la première Coupe du Monde de la FIFA en 1930 ?', 'Brésil', 0, 'Uruguay', 1, 'Allemagne', 0, 'Argentine', 0);
call CreateQuest(1, 'Combien de titres NBA Michael Jordan a-t-il remportés avec les Chicago Bulls ?', '5', 0, '6', 1, '7', 0, '8', 0);
call CreateQuest(2, 'Quel est l\'océan le plus grand de la Terre ?', 'Océan Atlantique', 0, 'Océan Pacifique', 1, 'Océan Indien', 0, 'Océan Arctique', 0);
call CreateQuest(1, 'Quel est le plus petit pays du monde ?', 'Monaco', 0, 'Vatican', 1, 'Saint-Marin', 0, 'Nauru', 0);
call CreateQuest(3, 'Quel est le plus petit os du corps humain ?', 'Clé de bras', 0, 'Stapes dans l\'oreille moyenne', 1, 'Fémur', 0, 'Coccyx', 0);
call CreateQuest(2, 'Combien d\'yeux a une araignée ?', '4', 0, '6', 0, '8', 1, '10', 0);

call CreateQuest(1, 'Quelle est la langue officielle de la Grèce ?', 'Grec', 1, 'Français', 0, 'Anglais', 0, 'Allemand', 0);
call CreateQuest(2, 'Qu\'est-ce qui cause les pannes de courant les plus fréquentes aux États-Unis ?', 'Souris', 0, 'Oiseaux', 0, 'Squirrels', 1, 'Chats', 0);
call CreateQuest(3, 'Quel est le roc le plus dur ?', 'Fer', 0, 'Granite', 0, 'Diamant', 1, 'Marbre', 0);
call CreateQuest(1, 'Quel est le plat national de la Chine ?', 'Noodles', 0, 'Peking duck', 1, 'Dim Sum', 0, 'Chow Mein', 0);
call CreateQuest(2, 'Quel pays a donné la Statue de la Liberté aux États-Unis ?', 'Espagne', 0, 'Italie', 0, 'France', 1, 'Royaume-Uni', 0);
call CreateQuest(1, 'De quoi sont composés les ongles ?', 'Kératine', 1, 'Collagène', 0, 'Calcium', 0, 'Acide aminé', 0);
call CreateQuest(3, 'Quelle est la fleur nationale des Pays-Bas ?', 'Rose', 0, 'Tulipe', 1, 'Lys', 0, 'Violette', 0);
call CreateQuest(2, 'En quelle année la guerre froide a-t-elle pris fin ?', '1990', 0, '1989', 1, '1985', 0, '1995', 0);
call CreateQuest(1, 'Quel est l\'animal national de l\'Australie ?', 'Koala', 0, 'Kangourou', 1, 'Émeu', 0, 'Crocodile', 0);
call CreateQuest(3, 'Quelle est la plus grande chaîne de montagnes du monde ?', 'Les Alpes', 0, 'Les Andes', 0, 'Les Grandes Himalayas', 1, 'Les Rocheuses', 0);

call CreateQuest(2, 'Qu\'est-ce qui peut porter malchance s\'il est cassé ?', 'Miroir', 1, 'Verre', 0, 'Porcelaine', 0, 'Vase', 0);
call CreateQuest(1, 'Quelle est la lettre la plus couramment utilisée dans l\'alphabet anglais ?', 'Lettre E', 1, 'Lettre A', 0, 'Lettre T', 0, 'Lettre S', 0);
call CreateQuest(3, 'Quel est le plus grand organe interne du corps humain ?', 'Foie', 1, 'Cœur', 0, 'Reins', 0, 'Estomac', 0);
call CreateQuest(1, 'De quoi est fait un palet de hockey sur glace ?', 'Plastique', 0, 'Rubber', 1, 'Métal', 0, 'Bois', 0);
call CreateQuest(2, 'Que représentent les 50 étoiles blanches sur un drapeau américain ?', 'Les 50 présidents', 0, 'Les 50 États de l\'union', 1, 'Les 50 colonies', 0, 'Les 50 symboles', 0);
call CreateQuest(3, 'Quel est le plus grand parc national du monde ?', 'Yellowstone', 0, 'Tassili n\'Ajjer, désert du Sahara', 1, 'Banff', 0, 'Grand Canyon', 0);
call CreateQuest(1, 'Qui est le poète aveugle ?', 'Homer', 0, 'John Milton', 1, 'William Shakespeare', 0, 'Sylvia Plath', 0);
call CreateQuest(2, 'Qui a écrit "Orgueil et Préjugés" ?', 'Emily Dickinson', 0, 'Jane Austen', 1, 'Charlotte Brontë', 0, 'Virginia Woolf', 0);
call CreateQuest(3, 'Quel est l\'hymne national le plus long du monde ?', 'Mexique, avec 100 couplets', 0, 'Grèce, avec 158 strophes', 1, 'France, avec 100 strophes', 0, 'Espagne, avec 120 couplets', 0);
call CreateQuest(2, 'Quel est le plus grand producteur de vanille au monde ?', 'Seychelles', 0, 'Madagascar', 1, 'Indonésie', 0, 'Vietnam', 0);
call CreateQuest(1, 'En quelle année Benito Mussolini est-il devenu Premier ministre de l\'Italie ?', '1935', 0, '1922', 1, '1915', 0, '1930', 0);
call CreateQuest(3, 'Qui était le réalisateur du film "Titanic" ?', 'Steven Spielberg', 0, 'James Cameron', 1, 'George Lucas', 0, 'Martin Scorsese', 0);
call CreateQuest(2, 'Quel est un célèbre médicament dérivé de la plante de pavot ?', 'Cocaïne', 0, 'Opium', 1, 'Héroïne', 0, 'Morphine', 0);
call CreateQuest(3, 'Quel est le surnom du club de Premier League "Arsenal" ?', 'Les Dragons', 0, 'Les Gunners', 1, 'Les Verts', 0, 'Les Chevaliers', 0);
call CreateQuest(1, 'Qu\'est-ce que les êtres humains ne naissent pas avec ?', 'Dents de sagesse', 1, 'Cheveux', 0, 'Doigts', 0, 'Poumons', 0);
call CreateQuest(2, 'Quelle est la signification de DOS ?', 'Disk Operating System', 0, 'Disc Operating System', 1, 'Data Operating System', 0, 'Drive Operating System', 0);
call CreateQuest(1, 'Que s\'est-il passé le 15 avril 1912 ?', 'L\'arrivée du Titanic', 0, 'Le naufrage du Titanic', 1, 'La naissance de James Cameron', 0, 'La fin de la Première Guerre mondiale', 0);
call CreateQuest(3, 'Que produisent les vers ?', 'Miel', 0, 'Cacao', 0, 'Thaïlande', 0, 'Compost', 1);
call CreateQuest(2, 'Quel pays a accueilli la Coupe du Monde de cricket en 1983 ?', 'Australie', 0, 'Angleterre', 1, 'Inde', 0, 'Afrique du Sud', 0);
call CreateQuest(1, 'Qui est le septième président des États-Unis ?', 'Abraham Lincoln', 0, 'Andrew Jackson', 1, 'George Washington', 0, 'Thomas Jefferson', 0);

call CreateQuest(1, 'Quel est le plus grand reptile du monde ?', 'Crocodile marin', 1, 'Dragon de Komodo', 0, 'Python', 0, 'Alligator', 0);
call CreateQuest(3, 'Quand McDonald a-t-il été fondé ?', '1950', 0, '1940', 1, '1960', 0, '1935', 0);
call CreateQuest(2, 'Quel est le premier chant du célèbre film d\'enfants "Le Roi Lion" ?', 'Hakuna Matata', 0, 'Le cercle de la vie', 1, 'L’amour brille sous les étoiles', 0, 'Simba, le roi', 0);
call CreateQuest(1, 'Quelle est la devise du Japon ?', 'Yuan', 0, 'Yen', 1, 'Won', 0, 'Ringgit', 0);
call CreateQuest(2, 'Quel est le plus grand mammifère terrestre ?', 'Éléphant d\'Afrique', 0, 'Rhinocéros géant', 1, 'Girafe', 0, 'Bison', 0);
call CreateQuest(3, 'Quel oiseau vit en Antarctique et ne peut pas voler ?', 'Albatros', 0, 'Penguin', 1, 'Pétrel', 0, 'Manchot', 0);
call CreateQuest(1, 'Quel est l\'endroit le plus froid de la Terre ?', 'Sibérie', 0, 'Oymyakon, cercle Arctique', 1, 'Groenland', 0, 'Pôle Sud', 0);
call CreateQuest(2, 'Quelle vitamine le Soleil nous donne-t-il ?', 'Vitamine C', 0, 'Vitamine D', 1, 'Vitamine A', 0, 'Vitamine B12', 0);
call CreateQuest(3, 'Qui est l\'auteur du livre intitulé "The Audacity of Hope" ?', 'Bill Clinton', 0, 'Barack Obama', 1, 'Hillary Clinton', 0, 'Joe Biden', 0);
call CreateQuest(2, 'Madrid est la capitale de quel pays ?', 'Portugal', 0, 'Espagne', 1, 'Italie', 0, 'Grèce', 0);
call CreateQuest(1, 'Les canneberges sont originaires de quel continent ?', 'Afrique', 0, 'Amérique du Nord', 1, 'Europe', 0, 'Asie', 0);
call CreateQuest(3, 'Quel est l\'autre nom des îles Sandwich ?', 'Îles Galapagos', 0, 'Îles Hawaïennes', 1, 'Îles Fiji', 0, 'Îles Malouines', 0);
call CreateQuest(1, 'Quelle est la forme complète de FOMO ?', 'Fear Of Missing Option', 0, 'Fear Of Missing Out', 1, 'Feeling Of Missing Out', 0, 'Fear Of Missing Object', 0);
call CreateQuest(2, 'Quel animal marin n\'a pas d\'os dans son corps ?', 'Poisson', 0, 'Requin', 1, 'Raie', 0, 'Méduse', 0);
call CreateQuest(3, 'Où est située Zurich ?', 'France', 0, 'Suisse', 1, 'Autriche', 0, 'Allemagne', 0);
call CreateQuest(2, 'Qui est l\'auteur de "David Copperfield" ?', 'Jane Austen', 0, 'Charles Dickens', 1, 'Mark Twain', 0, 'Herman Melville', 0);
call CreateQuest(1, 'Quel est le nom de la peur des araignées ?', 'Araknautisme', 0, 'Arachnophobie', 1, 'Spidophobia', 0, 'Insectophobie', 0);
call CreateQuest(3, 'Quel mammifère terrestre n\'a pas de corde vocale ?', 'Éléphant', 0, 'Girafe', 1, 'Cheval', 0, 'Kangourou', 0);
call CreateQuest(2, 'Quelle est la capitale de l\'Indonésie ?', 'Bali', 0, 'Jakarta', 1, 'Copenhague', 0, 'Manille', 0);
call CreateQuest(1, 'Qui a chanté la chanson "Heal The World" ?', 'Elton John', 0, 'Michael Jackson', 1, 'George Michael', 0, 'Prince', 0);
call CreateQuest(3, 'Qui est l\'auteur de "Les Hauts de Hurlevent" ?', 'Charlotte Brontë', 0, 'Emily Brontë', 1, 'Jane Austen', 0, 'Mary Shelley', 0);

call CreateQuest(2, 'Quel signe du zodiaque a un arc et une flèche ?', 'Sagittaire', 1, 'Scorpion', 0, 'Cancer', 0, 'Bélier', 0);
call CreateQuest(1, 'Quelle entreprise possède Porsche ?', 'BMW', 0, 'Volkswagen', 1, 'Audi', 0, 'Mercedes-Benz', 0);
call CreateQuest(3, 'Nommer un navigateur web célèbre ?', 'Mozilla Firefox', 0, 'Google Chrome', 1, 'Safari', 0, 'Opera', 0);
call CreateQuest(2, 'Comment est mieux connu "la ville de l\'amour fraternel" ?', 'Chicago', 0, 'Philadelphie', 1, 'Paris', 0, 'Rome', 0);
call CreateQuest(1, 'Qui est le célèbre artiste espagnol connu pour avoir cofondé le mouvement cubiste ?', 'Salvador Dalí', 0, 'Pablo Picasso', 1, 'Francisco Goya', 0, 'Joan Miró', 0);
call CreateQuest(2, 'En quelle année William Shakespeare est-il né ?', '1600', 0, '1564', 1, '1588', 0, '1532', 0);
call CreateQuest(3, 'Quel est le lac le plus long du monde ?', 'Lac Victoria', 0, 'Lac Tanganyika, Afrique de l\'Est', 1, 'Lac Baïkal', 0, 'Lac Mékong', 0);
call CreateQuest(1, 'Où se situe le Mont Everest ?', 'Inde et Chine', 0, 'Entre le Népal et le Tibet', 1, 'Pakistan et Inde', 0, 'Chine et Mongolie', 0);
call CreateQuest(3, 'Qui est mieux connu sous le nom de "La voix de Dieu" ?', 'James Earl Jones', 0, 'Morgan Freeman', 1, 'Samuel L. Jackson', 0, 'Arnold Schwarzenegger', 0);
call CreateQuest(2, 'Quel animal marin peut retenir sa respiration pendant cinq heures sous l\'eau ?', 'Dauphin', 0, 'Tortue de mer', 1, 'Baleine', 0, 'Requin', 0);
call CreateQuest(1, 'Quelle partie d\'un atome porte une charge positive ?', 'Neutron', 0, 'Proton', 1, 'Électron', 0, 'Noyau', 0);
call CreateQuest(3, 'Qui est l\'auteur de "Harry Potter" ?', 'J.R.R. Tolkien', 0, 'J.K. Rowling', 1, 'C.S. Lewis', 0, 'Stephen King', 0);
call CreateQuest(2, 'Pouvez-vous dire le nom de la première femme à recevoir le prix Nobel en 1903 ?', 'Marie Curie', 1, 'Rosalind Franklin', 0, 'Dorothy Crowfoot Hodgkin', 0, 'Ada Lovelace', 0);
call CreateQuest(1, 'Dans quel pays se trouve "La tour penchée de Pise" ?', 'France', 0, 'Italie', 1, 'Espagne', 0, 'Grèce', 0);
call CreateQuest(3, 'Comment était anciennement connu l\'Éthiopie ?', 'Méroé', 0, 'Abyssinie', 1, 'Soudan', 0, 'Nubie', 0);
call CreateQuest(2, 'Où se trouve le plus grand zoo du monde ?', 'Allemagne', 0, 'Caroline du Nord', 1, 'Australie', 0, 'France', 0);
call CreateQuest(1, 'Quel animal a les plus gros yeux ?', 'Poisson lune', 0, 'Calmar géant', 1, 'Lobster', 0, 'Cachalot', 0);
call CreateQuest(3, 'Quelle pièce d\'échecs peut se déplacer uniquement en ligne droite ?', 'Reine', 0, 'Tours', 1, 'Roi', 0, 'Fou', 0);
call CreateQuest(2, 'Qui a inventé le vaccin contre la rougeole ?', 'Louis Pasteur', 0, 'Maurice Hilleman', 1, 'Edward Jenner', 0, 'Jonas Salk', 0);

call CreateQuest(2, 'Quel est le plus grand entreprise technologique de Corée du Sud ?', 'Samsung', 1, 'LG', 0, 'Hyundai', 0, 'SK Telecom', 0);
call CreateQuest(1, 'Qui a officiellement annoncé un jour férié le jour de la Saint-Valentin ?', 'Henri VIII', 1, 'Louis XIV', 0, 'Napoléon Bonaparte', 0, 'Charles II', 0);
call CreateQuest(3, 'Comment s’appellent couramment les prunes séchées ?', 'Raisins secs', 0, 'Prunes', 1, 'Abricots secs', 0, 'Pommes séchées', 0);
call CreateQuest(2, 'Quel aliment comestible ne se gâte jamais ?', 'Sel', 0, 'Miel', 1, 'Sucre', 0, 'Vinaigre', 0);
call CreateQuest(1, 'Qui est le fondateur des Beatles ?', 'Paul McCartney', 0, 'John Lennon', 1, 'George Harrison', 0, 'Ringo Starr', 0);
call CreateQuest(2, 'Quels deux pays n’ont jamais manqué les Jeux Olympiques modernes ?', 'Australie et Grèce', 1, 'États-Unis et Russie', 0, 'Canada et Japon', 0, 'France et Allemagne', 0);
call CreateQuest(3, 'Qui a découvert la loi de la relativité ?', 'Isaac Newton', 0, 'Albert Einstein', 1, 'Galilée', 0, 'Niels Bohr', 0);
call CreateQuest(1, 'Quels tissus relient deux os ?', 'Articulaire', 0, 'Ligament', 1, 'Tendon', 0, 'Cartilage', 0);
call CreateQuest(3, 'Quel est l\'animal national de l\'Écosse ?', 'Lion', 0, 'Unicorn', 1, 'Dragon', 0, 'Aigle', 0);
call CreateQuest(2, 'Combien de temps dure la grossesse d\'un chien ?', '35 à 45 jours', 0, '58 à 68 jours', 1, '45 à 55 jours', 0, '50 à 60 jours', 0);
call CreateQuest(1, 'Nommez un mammifère qui pond des œufs ?', 'Échidné', 0, 'Duck-billed platypus', 1, 'Hérisson', 0, 'Rat', 0);
call CreateQuest(2, 'Comment les muscles sont-ils reliés aux os ?', 'Par les nerfs', 0, 'Par les tendons', 1, 'Par les ligaments', 0, 'Par la moelle osseuse', 0);
call CreateQuest(3, 'Quel est le jour le plus court de l\'année ?', '21 décembre, solstice d\'hiver', 0, '22 décembre, solstice d\'hiver', 1, '20 décembre, solstice d\'hiver', 0, '25 décembre, solstice d\'hiver', 0);
call CreateQuest(2, 'Quel est l\'étoile la plus brillante dans le ciel nocturne ?', 'Vega', 0, 'Sirius', 1, 'Canopus', 0, 'Altair', 0);
call CreateQuest(1, 'Le prix Nobel porte le nom de qui ?', 'Alfred Nobel', 1, 'Albert Einstein', 0, 'Marie Curie', 0, 'Isaac Newton', 0);
call CreateQuest(3, 'Quel état des États-Unis a le surnom de "Golden State" ?', 'Floride', 0, 'California', 1, 'Texas', 0, 'New York', 0);
call CreateQuest(2, 'Quelle est la devise de l\'Ukraine ?', 'Grivna ukrainienne', 1, 'Rouble', 0, 'Hryvnia ukrainienne', 0, 'Zloty', 0);
call CreateQuest(1, 'Nommer le médecin grec qui gardait les dossiers médicaux de ses patients ?', 'Hippocrate', 1, 'Galien', 0, 'Avicenne', 0, 'Paracelse', 0);
call CreateQuest(2, 'Quels deux éléments restent liquides à température ambiante ?', 'Mercure et Brome', 1, 'Mercure et Plomb', 0, 'Plomb et Sodium', 0, 'Bromine et Acide sulfurique', 0);
call CreateQuest(3, 'Combien de fuseaux horaires avons-nous ?', '12', 0, '24', 1, '48', 0, '36', 0);
call CreateQuest(2, 'Où se produisent la plupart des tsunamis ?', 'Indonésie', 1, 'Japon', 0, 'Chili', 0, 'Inde', 0);
call CreateQuest(1, 'Quel est le nom des premières dents des humains ?', 'Dents de lait', 0, 'Dents de sagesse', 0, 'Dents primaires', 0, 'Dents de lait', 1);
call CreateQuest(3, 'Qui a inventé le concept de la décimale en mathématiques ?', 'Isaac Newton', 0, 'John Napier', 1, 'Galilée', 0, 'Euler', 0);
call CreateQuest(2, 'Qui a inventé la dynamite ?', 'John Nobel', 0, 'Alfred Nobel', 1, 'Isaac Newton', 0, 'Michael Faraday', 0);
call CreateQuest(1, 'Qui est la première personne à avoir marché sur la lune ?', 'Buzz Aldrin', 0, 'Neil Armstrong', 1, 'Yuri Gagarin', 0, 'John Glenn', 0);
call CreateQuest(2, 'Où a eu lieu la catastrophe de Tchernobyl ?', 'Ukraine', 1, 'Biélorussie', 0, 'Russie', 0, 'Moldavie', 0);
call CreateQuest(3, 'Quel type de raisin est utilisé pour fabriquer le vin rouge de Bourgogne ?', 'Pinot noir', 1, 'Chardonnay', 0, 'Cabernet Sauvignon', 0, 'Merlot', 0);
call CreateQuest(2, 'Quel est le bicarbonate de sodium couramment connu ?', 'Poudre à pâte', 0, 'Bicarbonate de sodium', 1, 'Cendre', 0, 'Sel de cuisine', 0);
call CreateQuest(1, 'Où se trouve la porte de Brandebourg ?', 'Munich', 0, 'Berlin, Allemagne', 1, 'Hambourg', 0, 'Cologne', 0);
call CreateQuest(3, 'Quel est l\'épice la plus chère du monde ?', 'Vanille', 0, 'Safran', 1, 'Coriandre', 0, 'Cumin', 0);
call CreateQuest(2, 'Quel est l\'instrument musical le plus populaire ?', 'Guitare', 0, 'Piano', 1, 'Batterie', 0, 'Violoncelle', 0);

call CreateQuest(2, 'Quels deux instruments combinent pour créer le Banjolele ?', 'Banjo et ukulélé', 1, 'Guitare et banjo', 0, 'Guitare et ukulélé', 0, 'Mandoline et banjo', 0);
call CreateQuest(1, 'Nommer un personnage célèbre de Walt Disney ?', 'Mickey Mouse', 1, 'Donald Duck', 0, 'Goofy', 0, 'Pluto', 0);
call CreateQuest(3, 'En quelle année Walt Disney est-il décédé ?', '1964', 0, '1966', 1, '1970', 0, '1958', 0);
call CreateQuest(2, 'Nommer un roman de William Shakespeare ?', 'Macbeth', 0, 'Hamlet, Le Prince du Danemark', 1, 'Roméo et Juliette', 0, 'Othello', 0);
call CreateQuest(1, 'Quel est le métal le plus lourd du monde ?', 'Platine', 0, 'Osmium', 1, 'Iridium', 0, 'Mercure', 0);
call CreateQuest(2, 'Quel est le métal le plus léger trouvé sur Terre ?', 'Aluminium', 0, 'Magnésium', 1, 'Lithium', 0, 'Calcium', 0);
call CreateQuest(3, 'Quand William Wordsworth a-t-il écrit son premier poème ?', '1790', 0, '1793', 1, '1800', 0, '1796', 0);
call CreateQuest(2, 'Qui est le mari de Hillary Clinton ?', 'George W. Bush', 0, 'Bill Clinton', 1, 'Barack Obama', 0, 'Joe Biden', 0);
call CreateQuest(1, 'Quel est le plus grand continent du monde ?', 'Afrique', 0, 'Asie', 1, 'Amérique', 0, 'Europe', 0);
call CreateQuest(2, 'Quel pays est connu sous le nom de pays du soleil levant ?', 'Chine', 0, 'Japon', 1, 'Corée du Sud', 0, 'Vietnam', 0);
call CreateQuest(3, 'Quel est le surnom officiel de la Floride ?', 'État de la mer', 0, 'L\'État du soleil', 1, 'L\'État des palmiers', 0, 'L\'État des plages', 0);
call CreateQuest(2, 'Combien de pays composent les îles britanniques ?', '5', 0, '4', 1, '3', 0, '6', 0);
call CreateQuest(1, 'Combien de degrés fait un cercle ?', '360', 1, '180', 0, '90', 0, '720', 0);
call CreateQuest(3, 'En quelle année Microsoft a-t-il été fondé ?', '1980', 0, '1975', 1, '1985', 0, '1990', 0);
call CreateQuest(2, 'Combien de côtés a un pentagone ?', '4', 0, '5', 1, '6', 0, '7', 0);
call CreateQuest(1, 'Qui est l’auteur de Cendrillon ?', 'Les frères Grimm', 0, 'Charles Perrault', 1, 'Hans Christian Andersen', 0, 'Louisa May Alcott', 0);
call CreateQuest(3, 'Quel personnage fictif célèbre a été créé en 1933 ?', 'Batman', 0, 'Superman', 1, 'Spider-Man', 0, 'Captain America', 0);
call CreateQuest(2, 'Quel est le sport national des États-Unis ?', 'Basketball', 0, 'Baseball', 1, 'Football', 0, 'Hockey', 0);
call CreateQuest(1, 'Comment s’appelle le symbole hashtag techniquement ?', 'Hashsign', 0, 'Octothorpe', 1, 'Pound', 0, 'Sharp', 0);
call CreateQuest(3, 'Que représentent les 100 plis dans le chapeau d\'un chef ?', '100 types de plats', 0, '100 façons de cuisiner des œufs', 1, '100 techniques de cuisson', 0, '100 années de tradition culinaire', 0);
call CreateQuest(2, 'Quelle est la longueur du plus long voile de mariage ?', '5000 pieds', 0, '23000 pieds', 1, '10000 pieds', 0, '15000 pieds', 0);
call CreateQuest(1, 'Dans quel pays la tarte aux pommes est-elle originaire ?', 'France', 0, 'Angleterre', 1, 'États-Unis', 0, 'Allemagne', 0);
call CreateQuest(3, 'Quel est le plus grand organisme vivant connu ?', 'Champignon géant', 0, 'Aspen Grove', 1, 'Corail de la grande barrière', 0, 'Baleine bleue', 0);
call CreateQuest(2, 'Que signifie M&M ?', 'Mars et Murrie', 1, 'Miller et Moore', 0, 'Mason et Mark', 0, 'Malone et Mathews', 0);
call CreateQuest(1, 'Qui a dit "C’est un petit pas pour l’homme, un bond de géant pour l’humanité" ?', 'Buzz Aldrin', 0, 'Neil Armstrong', 1, 'Michael Collins', 0, 'Yuri Gagarin', 0);
call CreateQuest(3, 'Quel est le poids du cœur d’une baleine bleue ?', '300 livres', 0, '400 livres', 1, '500 livres', 0, '600 livres', 0);
call CreateQuest(2, 'Quel oiseau peut imiter presque tous les sons qu’il entend ?', 'Perroquet', 0, 'Lyrebird', 1, 'Mynah', 0, 'Rossignol', 0);
call CreateQuest(1, 'Qui est connu sous le nom de roi du Rock and Roll ?', 'Chuck Berry', 0, 'Elvis Presley', 1, 'Jerry Lee Lewis', 0, 'Little Richard', 0);
call CreateQuest(3, 'Quel fut le premier soda à être utilisé dans l’espace ?', 'Pepsi', 0, 'Coca-Cola', 1, '7-Up', 0, 'Sprite', 0);

call CreateQuest(2, 'Quelle université propose un diplôme en viticulture et œnologie (vinification)?', 'Université Cornell', 1, 'Université de Stanford', 0, 'Université de Harvard', 0, 'Université de Californie', 0);
call CreateQuest(1, 'Nommez l\'oiseau d\'état populaire de la Caroline du Nord?', 'Cardinal', 1, 'Aigle', 0, 'Geai bleu', 0, 'Colibri', 0);
call CreateQuest(3, 'Combien de raisins sont utilisés dans une bouteille de vin moyenne?', '700 raisins', 1, '500 raisins', 0, '1000 raisins', 0, '1200 raisins', 0);
call CreateQuest(2, 'Comment appelle-t-on la peur du nombre 13?', 'Triskaidekaphobia', 1, 'Hexakosioihexekontahexaphobia', 0, 'Numerophobia', 0, 'Thalassophobia', 0);
call CreateQuest(1, 'Qu\'est-ce qui a été interdit dans les restaurants japonais par la loi?', 'Donner des pourboires', 1, 'Servir de l\'alcool après minuit', 0, 'Servir du poisson cru', 0, 'Utiliser des baguettes', 0);
call CreateQuest(2, 'Qu\'est-ce qui rend la ville de La Paz en Bolivie exempte d\'incendie?', 'Altitude', 1, 'Climat', 0, 'Végétation riche', 0, 'Manque d\'oxygène', 0);
call CreateQuest(3, 'En quelle année les Oscars ont-ils été diffusés pour la première fois à la radio?', '1930', 1, '1927', 0, '1945', 0, '1935', 0);
call CreateQuest(2, 'Pour quoi sont décernés les Grammy Awards?', 'Musique', 1, 'Film', 0, 'Télévision', 0, 'Sports', 0);
call CreateQuest(1, 'Comment s\'appelle la maison des Esquimaux?', 'Igloo', 1, 'Yourte', 0, 'Tente', 0, 'Cabane', 0);
call CreateQuest(3, 'Nommez un fluide corporel?', 'Sang', 1, 'Urine', 0, 'Salive', 0, 'Sueur', 0);
call CreateQuest(2, 'Nommez la plus petite race de chien?', 'Chihuahuas', 1, 'Poméranien', 0, 'Yorkshire Terrier', 0, 'Teckel', 0);
call CreateQuest(1, 'Pouvez-vous nommer la première histoire de Sherlock Holmes écrite par Sir Arthur Canon Doyle ?', 'Une étude en rouge', 1, 'Le Chien des Baskerville', 0, 'Le Signe des Quatre', 0, 'Un scandale en Bohême', 0);
call CreateQuest(3, 'Quelle est la couleur de la pierre saphir?', 'Bleu', 1, 'Rouge', 0, 'Vert', 0, 'Jaune', 0);
call CreateQuest(2, 'Que font les Américains 22 fois par jour?', 'Ouvrir le réfrigérateur', 1, 'Vérifier leur téléphone', 0, 'Boire du café', 0, 'Regarder la télévision', 0);
call CreateQuest(1, 'Qu\'est-ce qui est illégal dans les vignobles français ?', 'Atterrissage de soucoupes volantes', 1, 'Cueillir du raisin le dimanche', 0, 'Vendre du vin non local', 0, 'Utiliser des pesticides', 0);
call CreateQuest(3, 'Que ne pouvez-vous pas faire dans les lieux publics de Floride si vous portez un maillot de bain?', 'Chanter', 1, 'Manger', 0, 'Conduire', 0, 'Marcher', 0);
call CreateQuest(2, 'Quelle nation a inventé le hockey?', 'Angleterre', 1, 'Canada', 0, 'Inde', 0, 'Suède', 0);
call CreateQuest(1, 'Quelle est la monnaie de la France?', 'Franc', 1, 'Euro', 0, 'Livre', 0, 'Dollar', 0);
call CreateQuest(3, 'Qui a inventé le beurre de cacahuète?', 'Marcellus Gilmore Edson', 1, 'George Washington Carver', 0, 'John Harvey Kellogg', 0, 'Joseph Rose', 0);
call CreateQuest(2, 'Quel signe de ponctuation termine une phrase interrogative?', 'Point d\'interrogation', 1, 'Point d\'exclamation', 0, 'Point', 0, 'Virgule', 0);
call CreateQuest(1, 'Quel a été le premier livre écrit par Agatha Christie?', 'La mystérieuse affaire de Styles', 1, 'Le Crime de l\'Orient-Express', 0, 'Et il n\'en resta aucun', 0, 'L\'adversaire secret', 0);
call CreateQuest(3, 'Comment appelle-t-on la peur des chiens ?', 'Cynophobie', 1, 'Zoophobie', 0, 'Anthophobie', 0, 'Ophidiophobie', 0);
call CreateQuest(2, 'Qui a lancé la société d\'enchères en ligne eBay?', 'Pierre Omidyar', 1, 'Jeff Bezos', 0, 'Mark Zuckerberg', 0, 'Larry Page', 0);
call CreateQuest(1, 'Qui a écrit le premier dictionnaire de la langue anglaise?', 'Samuel Johnson', 1, 'Noah Webster', 0, 'William Shakespeare', 0, 'John Milton', 0);
call CreateQuest(3, 'En quelle année le mur de Berlin a-t-il été démoli?', '1991', 1, '1989', 0, '1995', 0, '2000', 0);
call CreateQuest(2, 'Qui est devenu le 40e président des États-Unis?', 'Ronald Reagan', 1, 'Bill Clinton', 0, 'Jimmy Carter', 0, 'George HW Bush', 0);
call CreateQuest(1, 'Quel est le plus bel oiseau du monde?', 'Paon indien', 1, 'Quetzal', 0, 'Canard mandarin', 0, 'Ara', 0);
call CreateQuest(3, 'Nommez la première femme à marcher dans l\'espace?', 'Kathryn Sullivan', 1, 'Valentina Tereshkova', 0, 'Sally Ride', 0, 'Mae Jemison', 0);
call CreateQuest(2, 'Nom de la capitale de Cuba ?', 'La Havane', 1, 'Santiago', 0, 'Varadero', 0, 'Trinidad', 0) ;
call CreateQuest(1, 'Quel pays suit 8 fuseaux horaires?', 'Russie', 1, 'États-Unis', 0, 'Chine', 0, 'Brésil', 0);
call CreateQuest(3, 'Qui a créé Toy Story?', 'John Lasseter', 1, 'Steven Spielberg', 0, 'George Lucas', 0, 'Brad Bird', 0);
call CreateQuest(2, 'Quelle est la musique la plus vendue de tous les temps?', 'Candle in the Wind', 1, 'Bohemian Rhapsody', 0, 'Imagine', 0, 'Like a Rolling Stone', 0);
call CreateQuest(1, 'Qu\'est-ce qui ne peut que descendre et ne jamais monter ?', 'Pluie', 1, 'Gravité', 0, 'Âge', 0, 'Température', 0);
call CreateQuest(3, 'Qui a écrit le Livre de la jungle?', 'Rudyard Kipling', 1, 'Mark Twain', 0, 'Charles Dickens', 0, 'HG Wells', 0);
call CreateQuest(2, 'Qu\'est-ce qui peut être facilement brisé par beaucoup d\'entre nous?', 'Promesse', 1, 'Verre', 0, 'Cœur', 0, 'Os', 0);
call CreateQuest(1, 'Qui a inventé le concept du chiffre zéro ?', 'Aryabhatta', 1, 'Isaac Newton', 0, 'Brahmagupta', 0, 'Al-Khwarizmi', 0) ;
call CreateQuest(3, 'De quel pays provient le fromage mozzarella?', 'Italie', 1, 'France', 0, 'Grèce', 0, 'Espagne', 0);
call CreateQuest(2, 'Nommez la première femme pilote à marquer des points dans un Grand Prix?', 'Lella Lombardi', 1, 'Danica Patrick', 0, 'Michele Mouton', 0, 'Jochen Rindt', 0);
call CreateQuest(1, 'Quelle est la longueur de la plage de quatre-vingt-dix milles de Nouvelle-Zélande?', '88 kilomètres', 1, '90 kilomètres', 0, '100 kilomètres', 0, '120 kilomètres', 0);
call CreateQuest(3, 'Quel pays célèbre l\'Oktoberfest?', 'Munich, Allemagne', 1, 'Autriche', 0, 'Suisse', 0, 'États-Unis', 0);
call CreateQuest(2, 'Nommez le plat italien célèbre dans le monde entier?', 'Risotto aux champignons et pizza Margarita', 1, 'Lasagnes', 0, 'Spaghettis', 0, 'Raviolis', 0);

call CreateQuest(2, 'Pouvez-vous nommer le bateau de chasse au requin de Quint dans le film « Les Dents de la mer » ?', 'L\'Orque', 1, 'Le Léviathan', 0, 'Le Chasseur de requins', 0, 'Le Grand Blanc', 0);
call CreateQuest(1, 'Qui a créé le roi de la nuit ?', 'Les enfants de la forêt', 1, 'Les Marcheurs Blancs', 0, 'Les Premiers Hommes', 0, 'La Reine de la Nuit', 0);
call CreateQuest(3, 'Combien de touches noires voit-on généralement sur un piano traditionnel?', '32', 1, '36', 0, '30', 0, '28', 0);
call CreateQuest(2, 'Qui a conçu les anneaux olympiques?', 'Pierre de Coubertin', 1, 'John Edson', 0, 'James Naismith', 0, 'Baron Pierre', 0);
call CreateQuest(1, 'Qui a créé la flamme olympique?', 'Jan Wils', 1, 'John Williams', 0, 'Hans Christian Andersen', 0, 'Rafer Johnson', 0);
call CreateQuest(3, 'Qui a allumé la flamme olympique en 1984?', 'Rafer Johnson', 1, 'Carl Lewis', 0, 'Michael Johnson', 0, 'Evelyn Ashford', 0);
call CreateQuest(2, 'Nommez l\'animal terrestre le plus grand?', 'Girafe', 1, 'Éléphant', 0, 'Chameau', 0, 'Kangourou', 0);
call CreateQuest(1, 'Connaissez-vous l\'animal national du Royaume-Uni?', 'Lion', 1, 'Tigre', 0, 'Aigle', 0, 'Licorne', 0);
call CreateQuest(3, 'Pouvez-vous nommer la chaîne de montagnes du Colorado avec la ligne de partage des eaux continentales?', 'Les montagnes Rocheuses', 1, 'La Sierra Nevada', 0, 'Les Andes', 0, 'Les Appalaches', 0);
call CreateQuest(2, 'Où se trouvent les îles Marshall?', 'Océanie', 1, 'Caraïbes', 0, 'Asie du Sud-Est', 0, 'Pacifique Nord-Ouest', 0);
call CreateQuest(1, 'Nommez l\'herbe qui améliore la lactation après l\'accouchement?', 'Galactagogue', 1, 'Lavande', 0, 'Menthe poivrée', 0, 'Camomille', 0);
call CreateQuest(3, 'Connaissez-vous la péninsule partagée par le Portugal et l\'Espagne ?', 'Péninsule ibérique', 1, 'Péninsule italienne', 0, 'Péninsule balkanique', 0, 'Péninsule scandinave', 0);
call CreateQuest(2, 'Nommez la couverture brune et la plus externe de l\'arbre?', 'Écorce', 1, 'Feuille', 0, 'Racine', 0, 'Tronc', 0);
call CreateQuest(1, 'Nommez deux conifères?', 'Pins et sapins', 1, 'Chênes et érables', 0, 'Bouleaux et ormes', 0, 'Cèdres et pins', 0);
call CreateQuest(3, 'Connaissez-vous le nom du pays qui possède le plus grand nombre de lacs naturels?', 'Canada', 1, 'Finlande', 0, 'Suède', 0, 'Norvège', 0);
call CreateQuest(2, 'Quelle est la capitale de l\'Arabie saoudite?', 'Riyad', 1, 'La Mecque', 0, 'Djeddah', 0, 'Dammam', 0);
call CreateQuest(1, 'Dans quel pays se trouve le lac de Bled?', 'Slovénie', 1, 'Croatie', 0, 'Italie', 0, 'Suisse', 0);
call CreateQuest(3, 'Quel est le plat préféré de l\'hippopotame?', 'Herbe courte', 1, 'Fruit', 0, 'Algues', 0, 'Plantes aquatiques', 0);
call CreateQuest(2, 'Nommez la capitale du Pérou?', 'Lima', 1, 'Cusco', 0, 'Arequipa', 0, 'Trujillo', 0);
call CreateQuest(1, 'Qui a été nommé le plus jeune Premier ministre de Grande-Bretagne?', 'William Pitt', 1, 'David Cameron', 0, 'Winston Churchill', 0, 'Tony Blair', 0);
call CreateQuest(3, 'Quelle maladie a eu son premier vaccin en 1796?', 'Variole', 1, 'Polio', 0, 'Rougeole', 0, 'Typhoïde', 0);
call CreateQuest(2, 'Pouvez-vous nommer la première femme Premier ministre d\'Australie?', 'Julia Gillard', 1, 'Margaret Thatcher', 0, 'Golda Meir', 0, 'Indira Gandhi', 0);
call CreateQuest(1, 'Nommez une bière mexicaine célèbre?', 'Amandes', 0, 'Corona', 1, 'Modelo', 0, 'Pacifico', 0);
call CreateQuest(3, 'Quel est le nom chimique du sel commun?', 'Chlorure de sodium', 1, 'Chlorure de potassium', 0, 'Chlorure de calcium', 0, 'Chlorure de magnésium', 0);
call CreateQuest(2, 'Quel pays a remporté la Coupe du monde de la FIFA en 2018?', 'France', 1, 'Brésil', 0, 'Allemagne', 0, 'Argentine', 0);
call CreateQuest(1, 'Quel pays est célèbre pour la danse samba?', 'Brésil', 1, 'Argentine', 0, 'Cuba', 0, 'Colombie', 0);
call CreateQuest(3, 'Quel pays est célèbre pour ses bonbons?', 'France', 1, 'Belgique', 0, 'Suisse', 0, 'Italie', 0);
call CreateQuest(2, 'Nommez le pays connu comme le pays des gâteaux?', 'Écosse', 1, 'Irlande', 0, 'Angleterre', 0, 'France', 0);
call CreateQuest(1, 'Nommez les cinq couleurs des anneaux olympiques?', 'Bleu, jaune, vert, noir et rouge', 1, 'Rouge, blanc, jaune, vert, noir', 0, 'Bleu, blanc, rouge, noir, vert', 0, 'Jaune, bleu, vert, rouge, blanc', 0);
call CreateQuest(3, 'Dans quel pays la harpe est-elle couramment jouée?', 'Irlande', 1, 'Écosse', 0, 'Pays de Galles', 0, 'Angleterre', 0);

call CreateQuest(2, 'Quel pays insulaire est célèbre pour sa course à pied?', 'Jamaïque', 1, 'Bahamas', 0, 'Cuba', 0, 'Barbade', 0);
call CreateQuest(1, 'Où se trouve l\'aéroport de Kindley Field?', 'Bermudes', 1, 'Bahamas', 0, 'Îles Caïmans', 0, 'Aruba', 0);
call CreateQuest(3, 'En quelle année Napoléon Bonaparte a été vaincu à Waterloo?', '1815', 1, '1799', 0, '1812', 0, '1820', 0);
call CreateQuest(2, 'Nommez la capitale de la Nouvelle-Zélande?', 'Wellington', 1, 'Auckland', 0, 'Christchurch', 0, 'Hamilton', 0);
call CreateQuest(1, 'En quelle année l\'opéra de Sydney a-t-il été construit?', '1959', 1, '1963', 0, '1957', 0, '1960', 0);
call CreateQuest(3, 'En quelle année les Jeux Olympiques ont-ils eu lieu à Tokyo, au Japon?', '2021', 1, '2016', 0, '2000', 0, '1964', 0);
call CreateQuest(2, 'Combien de fois l\'Argentine a-t-elle remporté la Coupe du monde de la FIFA?', 'Deux fois. En 1986 et 1978', 1, 'Trois fois. En 1986, 1978 et 2022', 0, 'Une fois. En 1986', 0, 'Cinq fois. En 1986, 1978, 1990, 1994 et 1998', 0);
call CreateQuest(1, 'Nommez les quatre fuseaux horaires utilisés aux États-Unis?', 'EST, MST, CST, PST', 1, 'EST, CST, PST, NST', 0, 'PST, CST, MST, EST', 0, 'CST, PST, EST, HST', 0);
call CreateQuest(3, 'Qui est le principal antagoniste d\'Othello?', 'Iago', 1, 'Othello', 0, 'Desdémone', 0, 'Cassio', 0);
call CreateQuest(2, 'Connaissez-vous le nombre de dents permanentes qu\'un chien possède?', '42', 1, '30', 0, '36', 0, '24', 0);
call CreateQuest(1, 'De quoi sont faits les igloos?', 'Neige comprimée', 1, 'Briques de glace', 0, 'Bois', 0, 'Argile', 0);
call CreateQuest(3, 'Quelle est la plus grande église du monde?', 'Basilique Saint-Pierre, Cité du Vatican', 1, 'Notre-Dame, France', 0, 'Sagrada Familia, Espagne', 0, 'Cathédrale Saint-Paul, Royaume-Uni', 0);
call CreateQuest(2, 'Quelle est l\'année de naissance de Madonna?', '1958', 1, '1960', 0, '1956', 0, '1962', 0);
call CreateQuest(1, 'Nommez l\'aéroport de Johannesburg?', 'Aéroport international OR Tambo', 1, 'Aéroport international de Lanseria', 0, 'Aéroport international du Cap', 0, 'Aéroport international King Shaka', 0);
call CreateQuest(3, 'Quel est le nom du plus grand navire de croisière du monde?', 'Symphony of the Seas', 1, 'Oasis of the Seas', 0, 'Freedom of the Seas', 0, 'Quantum of the Seas', 0);
call CreateQuest(2, 'Quelle est la capitale de l\'État du Texas?', 'Austin', 1, 'Houston', 0, 'Dallas', 0, 'San Antonio', 0);
call CreateQuest(1, 'Qui est connue comme la reine du badminton ?', 'Saina Nehwal', 1, 'PV Sindhu', 0, 'Carolina Marin', 0, 'Li Xuerui', 0) ;
call CreateQuest(3, 'Qui a joué le rôle de Dumbledore dans le film Harry Potter?', 'Richard Harris', 1, 'Michael Gambon', 0, 'Johnny Depp', 0, 'Ian McKellen', 0);
call CreateQuest(2, 'Quel est le plus grand pays du monde en superficie?', 'Russie', 1, 'Canada', 0, 'Chine', 0, 'États-Unis', 0);
call CreateQuest(1, 'Nommez le plus grand pays du monde en termes de densité de population?', 'Chine', 1, 'Inde', 0, 'États-Unis', 0, 'Brésil', 0);
call CreateQuest(3, 'Pouvez-vous dire quand la marée noire du Golfe s\'est produite?', '2010', 1, '2005', 0, '2012', 0, '2008', 0);
call CreateQuest(2, 'Nommez la planète rouge?', 'Mars', 1, 'Vénus', 0, 'Saturne', 0, 'Jupiter', 0);
call CreateQuest(1, 'Qui a inventé le terme biophysique pour la première fois?', 'Karl Pearson en 1892', 1, 'Albert Einstein', 0, 'Niels Bohr', 0, 'Max Planck', 0);
call CreateQuest(3, 'Qui est connu comme le père de la bioinformatique?', 'Paulien Hogeweg', 1, 'George Church', 0, 'Jim Kent', 0, 'Michael Waterman', 0);
call CreateQuest(2, 'Qui est l\'auteur de « Le Tour du monde en 80 jours » ?', 'Jules Verne', 1, 'HG Wells', 0, 'Charles Dickens', 0, 'Léon Tolstoï', 0);
call CreateQuest(1, 'Nommez le père des mathématiques?', 'Archimède', 1, 'Euclide', 0, 'Pythagore', 0, 'Isaac Newton', 0);
call CreateQuest(3, 'Où se trouve le Machu Picchu?', 'Pérou', 1, 'Mexique', 0, 'Brésil', 0, 'Chili', 0);
call CreateQuest(2, 'Quelle est la langue maternelle du Danemark?', 'Danois', 1, 'Norvégien', 0, 'Suédois', 0, 'Néerlandais', 0);
call CreateQuest(1, 'Nommez la guitare la plus jouée?', 'Une guitare acoustique', 1, 'Guitare électrique', 0, 'Guitare basse', 0, 'Guitare classique', 0);
call CreateQuest(3, 'En quelle année les Nations Unies ont-elles été créées?', '1945', 1, '1939', 0, '1950', 0, '1920', 0);
call CreateQuest(2, 'Nommez la plus grande mine d\'or du monde?', 'Mine de Muruntau, Ouzbékistan', 1, 'Mine Goldstrike, États-Unis', 0, 'Mine de Pueblo Viejo, République dominicaine', 0, 'Mine de Grasberg, Indonésie', 0);
call CreateQuest(1, 'Nommez l\'océan à l\'ouest de l\'Amérique du Sud?', 'Océan Pacifique', 1, 'Océan Atlantique', 0, 'Océan Indien', 0, 'Océan Austral', 0);
call CreateQuest(3, 'Quelle est la longueur du fleuve Amazone?', '3977 miles', 1, '2200 miles', 0, '4000 miles', 0, '3000 miles', 0);
call CreateQuest(2, 'Où se trouve le fleuve Congo?', 'Afrique de l\'Ouest et du Centre', 1, 'Afrique du Nord', 0, 'Afrique de l\'Est', 0, 'Amérique du Sud', 0);
call CreateQuest(1, 'Qui a inventé l\'hélium ?', 'Pierre Jules Cesar Janssen', 1, 'Marie Curie', 0, 'Albert Einstein', 0, 'Robert Hooke', 0);

call CreateQuest(2, 'Quel est le numéro atomique du néon?', '10', 1, '12', 0, '8', 0, '6', 0);
call CreateQuest(3, 'Qui a créé le tableau périodique?', 'Le chimiste russe Dmitri Mendeleïev', 1, 'Marie Curie', 0, 'Albert Einstein', 0, 'John Dalton', 0);
call CreateQuest(1, 'Quel roman de Shakespeare a un antagoniste connu sous le nom de Shylock?', 'Le Marchand de Venise', 1, 'Hamlet', 0, 'Macbeth', 0, 'Roméo et Juliette', 0);
call CreateQuest(3, 'Quelle mer est une extension de l\'océan Indien?', 'Mer Rouge', 1, 'Mer d\'Arafura', 0, 'Mer d\'Arabie', 0, 'Baie du Bengale', 0);
call CreateQuest(2, 'Quel est le nom du groupe des papillons?', 'Flutter', 1, 'Swarm', 0, 'Horde', 0, 'Cluster', 0);
call CreateQuest(1, 'Quelle agence des Nations Unies œuvre pour le développement des enfants?', 'UNICEF', 1, 'OMS', 0, 'UNESCO', 0, 'HCR', 0);
call CreateQuest(3, 'Dans quel pays se trouve le siège de l\'UNESCO?', 'Paris, France', 1, 'Berlin, Allemagne', 0, 'Londres, Royaume-Uni', 0, 'New York, États-Unis', 0);
call CreateQuest(2, 'Nommez la plus grande université du monde en termes d\'inscriptions?', 'Indira Gandhi National Open University (IGNOU)', 1, 'Université de Phoenix', 0, 'Université de Californie', 0, 'Université de Harvard', 0);
call CreateQuest(1, 'Nommez le plus grand marsupial?', 'Kangourou roux', 1, 'Koala', 0, 'Diable de Tasmanie', 0, 'Wombat', 0);
call CreateQuest(3, 'Qui a proposé la théorie de l\'évolution?', 'Charles Darwin', 1, 'Albert Einstein', 0, 'Gregor Mendel', 0, 'Louis Pasteur', 0);
call CreateQuest(2, 'Où trouve-t-on les koalas?', 'Australie', 1, 'Nouvelle-Zélande', 0, 'Afrique du Sud', 0, 'Canada', 0);
call CreateQuest(1, 'Qui est l\'auteur du célèbre roman L\'Île au trésor ?', 'Robert Louis Stevenson', 1, 'Jules Verne', 0, 'Mark Twain', 0, 'Charles Dickens', 0);
call CreateQuest(3, 'Nommez la ville turque située entre l\'Asie et l\'Europe?', 'Istanbul', 1, 'Ankara', 0, 'Izmir', 0, 'Antalya', 0);
call CreateQuest(2, 'Dans quel pays les Nations Unies ont-elles leur siège en Afrique?', 'Nairobi', 1, 'Addis-Abeba', 0, 'Le Caire', 0, 'Lagos', 0);
call CreateQuest(1, 'Qui a écrit le poème « Arbres » ?', 'Joyce Kilmer', 1, 'Robert Frost', 0, 'Emily Dickinson', 0, 'William Blake', 0);
call CreateQuest(3, 'À quel pays appartient Sir Garfield Sobers?', 'Antilles', 1, 'Australie', 0, 'Inde', 0, 'Angleterre', 0);
call CreateQuest(2, 'Combien d\'océans y a-t-il dans le monde?', '4', 1, '5', 0, '3', 0, '7', 0);
call CreateQuest(1, 'Quelle est la monnaie officielle de la Colombie?', 'Peso colombien', 1, 'Real brésilien', 0, 'Peso argentin', 0, 'Peso chilien', 0);
call CreateQuest(3, 'Quelle est la langue officielle du Pérou?', 'Espagnol', 1, 'Portugais', 0, 'Quechua', 0, 'Aymara', 0);
call CreateQuest(2, 'Quelle est la langue officielle de l\'Uruguay?', 'Espagnol et portugais', 1, 'Espagnol', 0, 'Portugais', 0, 'Italien', 0);
call CreateQuest(1, 'Quelle est la monnaie utilisée en Égypte?', 'Livre égyptienne', 1, 'USD', 0, 'Euro', 0, 'Dinar libyen', 0);
call CreateQuest(3, 'Dans quelle ville se trouve Hudson Park?', 'New York City', 1, 'Los Angeles', 0, 'San Francisco', 0, 'Chicago', 0);
call CreateQuest(2, 'Quel est le plus long pont artificiel du monde?', 'Grand pont Danyang-Kunshan, Chine', 1, 'Chaussée du lac Pontchartrain, États-Unis', 0, 'Autoroute Bang Na, Thaïlande', 0, 'Pont Chongqing–Wanzhou sur le fleuve Yangtze, Chine', 0);
call CreateQuest(1, 'Nommez le plus long pont construit par l\'homme aux États-Unis?', 'La chaussée du lac Pontchartrain', 1, 'Pont du Golden Gate', 0, 'Pont de Brooklyn', 0, 'Pont de Tacoma Narrows', 0);
call CreateQuest(3, 'Nommez la capitale du Canada?', 'Ottawa', 1, 'Toronto', 0, 'Vancouver', 0, 'Montréal', 0);
call CreateQuest(2, 'Qui a été nommé plus jeune président des États-Unis?', 'John F. Kennedy', 1, 'Franklin D. Roosevelt', 0, 'Bill Clinton', 0, 'Barack Obama', 0);
call CreateQuest(1, 'Qui est le plus vieux président des États-Unis d\'Amérique à ce jour?', 'Joe Biden', 1, 'Ronald Reagan', 0, 'Donald Trump', 0, 'George HW Bush', 0);
call CreateQuest(3, 'Connaissez-vous le nom du moine légendaire qui a inventé le champagne ?', 'Dom Pérignon', 1, 'Jean-Baptiste Lanson', 0, 'Louis Roederer', 0, 'Henri Krug', 0);
call CreateQuest(2, 'Nommez le café le plus cher du monde?', 'Kopi Luwak', 1, 'Blue Mountain', 0, 'Jamaica Coffee', 0, 'Black Ivory Coffee', 0);
call CreateQuest(1, 'Quel pays est connu comme le « pays des roses » ?', 'Bulgarie', 1, 'Turquie', 0, 'Maroc', 0, 'Tunisie', 0);
call CreateQuest(3, 'En quelle année le célèbre groupe des Beatles a-t-il été formé?', '1960', 1, '1959', 0, '1965', 0, '1963', 0);
call CreateQuest(2, 'Quel est le plus long fleuve d\'Angleterre?', 'Rivière Severn', 1, 'Rivière Tamise', 0, 'Rivière Tyne', 0, 'Rivière Mersey', 0);
call CreateQuest(1, 'Qui est l\'auteur de « Alchemist » ?', 'Paulo Coelho', 1, 'Gabriel Garcia Marquez', 0, 'Isabel Allende', 0, 'Carlos Ruiz Zafón', 0) ;
call CreateQuest(3, 'Nommez le film le plus long jamais réalisé?', 'Logistique', 1, 'Cléopâtre', 0, 'Autant en emporte le vent', 0, 'Les Dix Commandements', 0);
call CreateQuest(2, 'En quelle année l\'Oscar a-t-il été introduit pour la première fois par les films de l\'Académie?', '1929', 1, '1930', 0, '1928', 0, '1932', 0);
call CreateQuest(1, 'Qui est l\'auteur du livre « Autant en emporte le vent » ?', 'Margaret Mitchell', 1, 'Harper Lee', 0, 'Mark Twain', 0, 'William Faulkner', 0);
call CreateQuest(3, 'Quelle est la voiture la plus chère du monde?', 'Lamborghini Veneno', 1, 'Bugatti La Voiture Noire', 0, 'Rolls-Royce Sweptail', 0, 'Ferrari 250 GTO', 0);
call CreateQuest(2, 'En quelle année le premier iPhone est-il sorti sur le marché?', '2007', 1, '2006', 0, '2008', 0, '2005', 0);
call CreateQuest(1, 'Nommez l\'entreprise créée par Bill Gates?', 'Microsoft Corporation', 1, 'Apple Inc.', 0, 'Google', 0, 'Amazon', 0);
call CreateQuest(3, 'Quel était le produit original vendu par Amazon?', 'Livres', 1, 'Électronique', 0, 'Vêtements', 0, 'Jouets', 0);
call CreateQuest(2, 'Nommez la couleur de voiture la plus populaire aux États-Unis?', 'Blanc', 1, 'Noir', 0, 'Argent', 0, 'Rouge', 0);
call CreateQuest(1, 'Nom d\'un volcan actif trouvé en Afrique ?', 'Nyamuragira', 1, 'Mont Kilimandjaro', 0, 'Mont Cameroun', 0, 'Mont Nyiragongo', 0) ;
call CreateQuest(3, 'Quelle est l\'année de lancement de Facebook?', '2004', 1, '2005', 0, '2003', 0, '2002', 0);
call CreateQuest(2, 'Qui a lancé Instagram?', 'Kevin Systrom', 1, 'Mark Zuckerberg', 0, 'Jack Dorsey', 0, 'Evan Spiegel', 0);

call CreateQuest(2, 'Quelle est la forme complète de HTTP?', 'Protocole de transfert hypertexte', 1, 'Processus de transfert hypertexte', 0, 'Protocole de transfert hypertexte', 0, 'Protocole de transaction hypertexte', 0);
call CreateQuest(3, 'Nommez le premier jouet annoncé à la télévision?', 'Mr. Potato head', 1, 'Barbie Doll', 0, 'Action Man', 0, 'Rubik\'s Cube', 0);
call CreateQuest(2, 'Comment s\'appelle le Boxing Day aux États-Unis?', 'Saint-Étienne', 1, 'Veille de Noël', 0, 'Jour de l\'An', 0, 'Thanksgiving', 0);
call CreateQuest(1, 'Nommez le pays connu pour ses éléphants blancs?', 'Thaïlande', 1, 'Inde', 0, 'Sri Lanka', 0, 'Cambodge', 0);
call CreateQuest(3, 'Quel était l\'ancien nom du Sri Lanka?', 'Ceylan', 1, 'Îles Ceylan', 0, 'République du Sri Lanka', 0, 'Serendib', 0);
call CreateQuest(2, 'Qui était le troisième président des États-Unis?', 'Thomas Jefferson', 1, 'George Washington', 0, 'John Adams', 0, 'James Madison', 0);
call CreateQuest(1, 'Qui est connu comme le roi de la pop?', 'Michael Jackson', 1, 'Elvis Presley', 0, 'Prince', 0, 'Justin Timberlake', 0);
call CreateQuest(3, 'Nommez la première femme Premier ministre de Grande-Bretagne?', 'Margaret Thatcher', 1, 'Theresa May', 0, 'Reine Elizabeth II', 0, 'Harriet Harman', 0);
call CreateQuest(2, 'Quand l\'OMS a-t-elle été créée?', '7 avril 1948', 1, '1er janvier 1946', 0, '15 juin 1950', 0, '12 décembre 1949', 0);
call CreateQuest(1, 'Quel ancien athlète américain sur piste a remporté 9 médailles d\'or aux Jeux olympiques?', 'Carl Lewis', 1, 'Michael Phelps', 0, 'Usain Bolt', 0, 'Florence Griffith Joyner', 0);
call CreateQuest(3, 'Qui était connu sous le nom de « Iron Mike » au début de sa carrière ?', 'Mike Tyson', 1, 'Evander Holyfield', 0, 'Muhammad Ali', 0, 'George Foreman', 0);
call CreateQuest(2, 'Pouvez-vous compter le nombre de côtes dans le corps humain?', '24', 1, '22', 0, '26', 0, '28', 0);
call CreateQuest(1, 'Quelle est la formule chimique du zirconium?', 'Zr', 1, 'Zn', 0, 'ZrO2', 0, 'ZrCl', 0);
call CreateQuest(3, 'Pouvez-vous dire à quel siècle Sir Isaac Newton est né ?', '17e siècle', 1, '16e siècle', 0, '18e siècle', 0, '19e siècle', 0);
call CreateQuest(2, 'Qu\'est-ce que le Barramundi?', 'Poisson', 1, 'Oiseau', 0, 'Reptile', 0, 'Mammifère', 0);
call CreateQuest(1, 'Combien d\'ailes a une abeille?', 'Quatre ailes', 1, 'Deux ailes', 0, 'Six ailes', 0, 'Huit ailes', 0);
call CreateQuest(3, 'Qu\'est-ce que le gelada?', 'Une espèce de singe', 1, 'Un type d\'oiseau', 0, 'Une sorte de reptile', 0, 'Un poisson', 0);
call CreateQuest(2, 'Qu\'est-ce que la phonologie?', 'L\'étude des sons', 1, 'L\'étude des langues', 0, 'L\'étude des mots', 0, 'L\'étude de la grammaire', 0);
call CreateQuest(1, 'Qu\'est-ce que « Yukon Gold »?', 'Une variété de pomme de terre', 1, 'Un type de poisson', 0, 'Un minéral', 0, 'Une variété de pomme', 0);
call CreateQuest(3, 'Qui a inventé les lunettes bifocales?', 'Benjamin Franklin', 1, 'Isaac Newton', 0, 'Thomas Edison', 0, 'Albert Einstein', 0);
call CreateQuest(2, 'Quelle est la forme complète d\'un GIF?', 'Format d\'échange graphique', 1, 'Fichier image général', 0, 'Format d\'entrée graphique', 0, 'Format d\'image global', 0);
call CreateQuest(1, 'Pouvez-vous nommer un ravageur bien connu qui détruit les pommes de terre?', 'Doryphore', 1, 'Criquet', 0, 'Chenille', 0, 'Fourmi', 0);
call CreateQuest(3, 'Comment appelle-t-on la myopie?', 'Myopie', 1, 'Hypermétropie', 0, 'Astigmatisme', 0, 'Presbytie', 0);
call CreateQuest(2, 'Qu\'est-ce qu\'une microseconde?', 'Un millionième de seconde', 1, 'Un millième de seconde', 0, 'Un milliardième de seconde', 0, 'Un centième de seconde', 0);
call CreateQuest(1, 'Nommez la capitale de l\'Arizona?', 'Phoenix', 1, 'Tucson', 0, 'Tempe', 0, 'Flagstaff', 0);
call CreateQuest(3, 'Nommez la capitale du Soudan?', 'Khartoum', 1, 'Le Caire', 0, 'Nairobi', 0, 'Addis-Abeba', 0);
call CreateQuest(2, 'Combien d\'États fédéraux y a-t-il en Allemagne?', '16', 1, '15', 0, '14', 0, '18', 0);
call CreateQuest(1, 'Quel est le plus grand État des États-Unis?', 'Alaska', 1, 'Texas', 0, 'Californie', 0, 'Montana', 0);
call CreateQuest(3, 'Quelle est la langue officielle de la Guinée équatoriale?', 'Espagnol', 1, 'Portugais', 0, 'Français', 0, 'Anglais', 0);
call CreateQuest(2, 'Nommez le pays qui n\'appartient pas à l\'Union soviétique?', 'Roumanie', 1, 'Estonie', 0, 'Lettonie', 0, 'Ukraine', 0);
call CreateQuest(1, 'Comment s\'appelle l\'ensemble des marches de Rome, en Italie?', 'Escalier espagnol', 1, 'Escalier du Panthéon', 0, 'Escalier du Vatican', 0, 'Escalier de Trevi', 0);
call CreateQuest(3, 'Nommez le boxeur communément appelé « Le champion du peuple »?', 'Muhammad Ali', 1, 'Mike Tyson', 0, 'George Foreman', 0, 'Sugar Ray Leonard', 0);
call CreateQuest(2, 'Quel est le fruit national des États-Unis?', 'Myrtille', 1, 'Pomme', 0, 'Orange', 0, 'Fraise', 0);
call CreateQuest(1, 'Nommez le fruit national du Royaume-Uni?', 'Pomme', 1, 'Poire', 0, 'Orange', 0, 'Raisin', 0);
call CreateQuest(3, 'Quel est le fruit national du Japon?', 'Kaki japonais', 1, 'Pêche', 0, 'Mangue', 0, 'Raisin', 0);
call CreateQuest(2, 'Quel est le sport national du Japon?', 'Sumo', 1, 'Baseball', 0, 'Judo', 0, 'Football', 0);
call CreateQuest(1, 'Quel pays est le berceau du cricket?', 'Angleterre', 1, 'Inde', 0, 'Australie', 0, 'Afrique du Sud', 0);
call CreateQuest(3, 'Nommez le sport national de la Pologne?', 'Moto speedway', 1, 'Football', 0, 'Volleyball', 0, 'Handball', 0);
call CreateQuest(2, 'Quel pays est célèbre pour le rugby?', 'Nouvelle-Zélande', 1, 'Afrique du Sud', 0, 'Australie', 0, 'Angleterre', 0);
call CreateQuest(1, 'Nommez la planète avec la gravité la plus élevée?', 'Jupiter', 1, 'Saturne', 0, 'Terre', 0, 'Mars', 0);
call CreateQuest(3, 'Nommez le premier album solo de Beyoncé?', 'Dangerously in Love', 1, 'I Am… Sasha Fierce', 0, 'Lemonade', 0, '4', 0);
call CreateQuest(2, 'Qui a chanté la célèbre chanson « You make me feel so young » ?', 'Frank Sinatra', 1, 'Dean Martin', 0, 'Bing Crosby', 0, 'Tony Bennett', 0);
call CreateQuest(1, 'Nommez le plus grand os du corps humain?', 'Fémur', 1, 'Tibia', 0, 'Radius', 0, 'Humerus', 0);
call CreateQuest(3, 'Nommez la fleur dont les bourgeons ont été échangés comme monnaie?', 'Tulipes', 1, 'Roses', 0, 'Jonquilles', 0, 'Lys', 0);
call CreateQuest(2, 'Connaissez-vous l\'animal national de la Grèce?', 'Le dauphin', 1, 'Lion', 0, 'Aigle', 0, 'Cheval', 0);
call CreateQuest(1, 'Quel est l\'animal national de la Finlande?', 'Ours brun', 1, 'Loup', 0, 'Élan', 0, 'Aigle', 0);
call CreateQuest(3, 'Nommez l\'animal marin le plus rapide?', 'Voilier', 1, 'Requin', 0, 'Dauphin', 0, 'Baleine bleue', 0);
call CreateQuest(2, 'Qui est l\'inventeur du vaccin contre la varicelle?', 'Michiaki Takahashi', 1, 'Louis Pasteur', 0, 'Edward Jenner', 0, 'Albert Calmette', 0);
call CreateQuest(1, 'Nommez le jardin considéré comme l\'une des sept merveilles du monde?', 'Les jardins suspendus de Babylone', 1, 'Le jardin d\'Eden', 0, 'Les jardins de Versailles', 0, 'Les jardins botaniques royaux', 0);
call CreateQuest(3, 'Comment s\'appellent les peurs des arbres?', 'Dendrophobie', 1, 'Anthophobie', 0, 'Nyctophobie', 0, 'Atychiphobie', 0);
call CreateQuest(2, 'Qu\'est-ce que l\'entomophobie?', 'Peur des insectes', 1, 'Peur des animaux', 0, 'Peur des hauteurs', 0, 'Peur des germes', 0);
call CreateQuest(1, 'Qui avait un petit agneau qui la suivait à l\'école ?', 'Mary', 1, 'Susan', 0, 'Emily', 0, 'Sarah', 0);

call CreateQuest(1, 'Nommez la plus grande espèce de singes?', 'Gorilles', 1, 'Orangs-outans', 0, 'Chimpanzés', 0, 'Gibbons', 0);
call CreateQuest(2, 'Connaissez-vous la personne qui a inventé le bikini?', 'Louis Reard', 1, 'Jacques Heim', 0, 'Coco Chanel', 0, 'Louis Vuitton', 0);
call CreateQuest(3, 'Nommez l\'océan qui entoure les Seychelles?', 'Océan Indien occidental', 1, 'Océan Indien', 0, 'Océan Pacifique', 0, 'Océan Atlantique', 0);
call CreateQuest(2, 'Nommez l\'océan qui entoure les îles Andaman et Nicobar?', 'La baie du Bengale', 1, 'Océan Indien', 0, 'Mer d\'Andaman', 0, 'Mer d\'Arabie', 0);
call CreateQuest(1, 'Comment connaît-on la plus grande araignée du monde?', 'Goliath mangeur d\'oiseaux, une sorte de tarentule', 1, 'Araignée errante brésilienne', 0, 'Araignée chasseuse', 0, 'Tarentule', 0);
call CreateQuest(3, 'Qui a écrit le livre « Notre homme à La Havane » ?', 'Graham Greene', 1, 'John le Carré', 0, 'Ian Fleming', 0, 'Tinker Tailor', 0);
call CreateQuest(2, 'Connaissez-vous le plus grand nombre premier à deux chiffres?', '97', 1, '89', 0, '91', 0, '93', 0);
call CreateQuest(1, 'Nommez la rivière qui traverse le Grand Canyon?', 'Rivière Colorado', 1, 'Rivière Missouri', 0, 'Rivière Amazone', 0, 'Nil', 0);
call CreateQuest(3, 'Connaissez-vous le nom de l\'arbre le plus grand?', 'Hyperion', 1, 'Coast Redwood', 0, 'Douglas Fir', 0, 'Giant Sequoia', 0);
call CreateQuest(2, 'Nommez le plus petit État des États-Unis?', 'Rhode Island', 1, 'Delaware', 0, 'Connecticut', 0, 'Hawaï', 0);
call CreateQuest(1, 'Pouvez-vous me dire le nom du continent où se trouve le plus grand désert du monde?', 'Afrique (désert du Sahara)', 1, 'Australie (Grand désert de Victoria)', 0, 'Asie (désert de Gobi)', 0, 'Amérique du Nord (désert de Mojave)', 0);
call CreateQuest(3, 'Quel pays a un symbole d\'épave dans son drapeau national?', 'Drapeau territorial des Bermudes', 1, 'Drapeau de Malte', 0, 'Drapeau des Bahamas', 0, 'Drapeau des Seychelles', 0);
call CreateQuest(2, 'Où trouve-t-on la statue de « La petite sirène » ?', 'Danemark', 1, 'Norvège', 0, 'Suède', 0, 'Finlande', 0);
call CreateQuest(1, 'Dans quel pays les sushis sont-ils originaires?', 'Japon', 1, 'Chine', 0, 'Corée', 0, 'Thaïlande', 0);
call CreateQuest(3, 'Quelle est la bière la plus vendue au monde?', 'Budweiser', 1, 'Heineken', 0, 'Corona', 0, 'Bud Light', 0);
call CreateQuest(2, 'Pouvez-vous me dire combien d\'heures un escargot dort ?', '3 ans', 1, '1 an', 0, '6 mois', 0, '2 ans', 0);
call CreateQuest(1, 'Quel est l\'animal le plus lent sur terre?', 'Paresseux à trois doigts', 1, 'Tortue', 0, 'Koala', 0, 'Paresseux', 0);
call CreateQuest(3, 'Combien de chambres cardiaques y a-t-il dans un cafard?', '12', 1, '5', 0, '3', 0, '9', 0);
call CreateQuest(2, 'Nommez l\'oiseau universel de la paix?', 'Colombe', 1, 'Aigle', 0, 'Hibou', 0, 'Colibri', 0);
call CreateQuest(1, 'Combien de pattes a une fourmi?', '6', 1, '4', 0, '8', 0, '10', 0);
call CreateQuest(3, 'Nommez l\'animal avec la tension artérielle la plus élevée?', 'Girafe', 1, 'Éléphant', 0, 'Lion', 0, 'Tigre', 0);
call CreateQuest(2, 'À quelle partie de la plante appartiennent le chou-fleur et le brocoli?', 'Fleur', 1, 'Feuille', 0, 'Racine', 0, 'Tige', 0);
call CreateQuest(1, 'Nommez l\'animal qui ne dort jamais?', 'Grenouille taureau', 1, 'Lion', 0, 'Chauve-souris', 0, 'Éléphant', 0);
call CreateQuest(3, 'Quel est le poisson récemment découvert dans le monde?', 'Paedocypris progenetica', 1, 'Coelacanth', 0, 'Goblin Shark', 0, 'Arapaima', 0);
call CreateQuest(2, 'Quel type d\'animal est un mandrill?', 'Singe', 1, 'Lézard', 0, 'Grenouille', 0, 'Ours', 0);
call CreateQuest(1, 'Comment appelle-t-on un groupe de hérissons?', 'Array', 1, 'Horde', 0, 'Pack', 0, 'Cluster', 0);
call CreateQuest(3, 'Comment appelle-t-on une biche?', 'Doe', 1, 'Bambi', 0, 'Fawn', 0, 'Doe-eyed', 0);
call CreateQuest(2, 'Nommez l\'oiseau qui est un signe de bonne chance?', 'Cigognes', 1, 'Aigle', 0, 'Pigeon', 0, 'Moineau', 0);
call CreateQuest(1, 'Quel était le plus vieux panda géant mort en 2016?', 'Jia Jia', 1, 'Bao Bao', 0, 'Ling Ling', 0, 'Xiao Xiao', 0);
call CreateQuest(3, 'Quel animal a le nom scientifique Hominoidea?', 'Singe', 1, 'Lion', 0, 'Tigre', 0, 'Éléphant', 0);
call CreateQuest(2, 'Comment s\'appelle un bébé renard?', 'Kits ou oursons', 1, 'Chiots', 0, 'Chatons', 0, 'Veaux', 0);
call CreateQuest(1, 'Dans quelle rivière trouveriez-vous des dauphins aveugles?', 'Indus River', 1, 'Amazon River', 0, 'Yangtze River', 0, 'Mississippi River', 0);
call CreateQuest(3, 'Quel est le nom scientifique du lion?', 'Panthera Leo', 1, 'Panthera tigris', 0, 'Panthera onca', 0, 'Felis catus', 0);
call CreateQuest(2, 'Nommez le pays où le jeu de snooker a été inventé?', 'Inde', 1, 'Angleterre', 0, 'Écosse', 0, 'Irlande', 0);
call CreateQuest(1, 'De quoi est faite une balle de tennis?', 'Caoutchouc et tissu', 1, 'Plastique', 0, 'Métal', 0, 'Mousse', 0);
call CreateQuest(3, 'Où les chiens ont-ils des glandes sudoripares?', 'Pattes', 1, 'Nez', 0, 'Aisselles', 0, 'Bouche', 0);
call CreateQuest(2, 'Comment appelle-t-on un dindon mâle?', 'Gobbler', 1, 'Tom', 0, 'Hen', 0, 'Cock', 0);
call CreateQuest(1, 'Comment appelle-t-on un bébé éléphant?', 'Veau', 1, 'Louveteau', 0, 'Kid', 0, 'Pup', 0);
call CreateQuest(3, 'En quelle année Thanksgiving est-il né?', '1621', 1, '1501', 0, '1750', 0, '1800', 0);
call CreateQuest(2, 'Qui a annoncé le début officiel de Thanksgiving aux États-Unis?', 'Président Abraham Lincoln', 1, 'George Washington', 0, 'Thomas Jefferson', 0, 'Franklin D. Roosevelt', 0);
call CreateQuest(1, 'En quelle année Thanksgiving est-il devenu un jour férié officiel?', '1941', 1, '1865', 0, '1910', 0, '1789', 0);
call CreateQuest(3, 'Quelle est l\'utilisation principale des plumes de dinde?', 'Alimentation animale', 1, 'Vêtements', 0, 'Décoration', 0, 'Matériel d\'écriture', 0);
call CreateQuest(2, 'Sur quel continent Thanksgiving est-il né?', 'Europe', 1, 'Amérique du Nord', 0, 'Asie', 0, 'Amérique du Sud', 0);
call CreateQuest(1, 'Pouvez-vous dire si une citrouille est un fruit ou un légume?', 'Fruit', 1, 'Légume', 0, 'Graine', 0, 'Herbe', 0);
call CreateQuest(3, 'Quel est le deuxième jour le plus chargé après Noël?', 'Halloween', 1, 'Jour de l\'An', 0, 'Black Friday', 0, 'Pâques', 0);
call CreateQuest(2, 'Pouvez-vous nommer la plus ancienne ville habitée du monde?', 'Damas', 1, 'Jéricho', 0, 'Athènes', 0, 'Le Caire', 0);
call CreateQuest(1, 'Nommez le célèbre tableau de Norman Rockwell?', 'La liberté de la peur', 1, 'Le problème avec lequel nous vivons tous', 0, 'Les quatre libertés', 0, 'Les commérages', 0);
call CreateQuest(3, 'Quel pays est la terre natale des lémuriens?', 'Madagascar', 1, 'Indonésie', 0, 'Inde', 0, 'Australie', 0);
call CreateQuest(2, 'Quel est le régime alimentaire préféré du panda géant?', 'Bambou', 1, 'Baies', 0, 'Poisson', 0, 'Fruits', 0);
call CreateQuest(1, 'Nommez le premier pays africain qualifié pour la Coupe du monde?', 'Égypte', 1, 'Cameroun', 0, 'Nigeria', 0, 'Afrique du Sud', 0);
call CreateQuest(3, 'Pouvez-vous nommer le plat signature servi chez Wimbledon?', 'Crème et fraises', 1, 'Fish and chips', 0, 'Hot dogs', 0, 'Pizza', 0);
call CreateQuest(2, 'Connaissez-vous le nom de naissance de Muhammad Ali?', 'Cassius Clay', 1, 'George Foreman', 0, 'Joe Frazier', 0, 'Larry Holmes', 0);
call CreateQuest(1, 'Nommez le pays sans son propre hymne national?', 'Chypre', 1, 'Espagne', 0, 'France', 0, 'Italie', 0);
call CreateQuest(3, 'Quel pays est connu pour ses habitants heureux?', 'Finlande', 1, 'Danemark', 0, 'Norvège', 0, 'Suède', 0);
call CreateQuest(2, 'Dans quel pays se produisent la plupart des tremblements de terre dans le monde?', 'Japon', 1, 'Indonésie', 0, 'Turquie', 0, 'Chili', 0);
call CreateQuest(1, 'Où trouve-t-on la forêt ancienne du monde?', 'Australie', 1, 'Afrique', 0, 'Amérique du Sud', 0, 'Asie', 0);
call CreateQuest(3, 'Nommez la planète la plus légère?', 'Mercure', 1, 'Vénus', 0, 'Mars', 0, 'Terre', 0);

-- "

-- items
call CreateItem('Epee de base', 'Une epee simple pour les debutants', 5, 100.0, 50.0, 'epee.png', 10, 0, 'arme', '50', 'Epee', '', 0, 10);
call CreateItem('Bouclier de base', 'Un bouclier simple pour les debutants', 7, 150.0, 75.0, 'bouclier.png', 10, 0, 'armure', 'Bois', 'Moyen', '', 0, 100);
call CreateItem('Potion de soin', 'Une potion qui soigne 50 PV', 1, 50.0, 25.0, 'potion.png', 255, 0, 'med', 'Soigne 50 PV', 'Instantane', 'Aucun', 50, 15);
call CreateItem('Pomme', 'Une pomme fraîche', 1, 10.0, 5.0, 'pomme.png', 250, 0, 'food', '50 kcal', 'Vitamines', 'Mineraux', 10, 50);
call CreateItem('Balle', 'Une balle de calibre 9mm', 1, 1.0, 0.5, 'balle.png', 0, 0, 'mun', '9mm', '', '', 0, 1000);
call CreateItem('Hache de guerre', 'Une hache puissante pour les combats', 8, 200.0, 100.0, 'hache.png', 20, 0, 'arme', '70', 'Hache', '', 0, 5);
call CreateItem('Casque en acier', 'Un casque robuste pour la protection', 3, 120.0, 60.0, 'casque.png', 15, 0, 'armure', 'Acier', 'Grand', '', 0, 50);
call CreateItem('Antidote', 'Un remede contre les poisons', 1, 80.0, 40.0, 'antidote.png', 255, 0, 'med', 'Guerit les poisons', 'Instantane', 'Aucun', 100, 20);
call CreateItem('Pain', 'Un pain frais et nourrissant', 2, 20.0, 10.0, 'pain.png', 250, 0, 'food', '200 kcal', 'Glucides', 'Fibres', 5, 30);
call CreateItem('Fusil', 'Un fusil de calibre 12', 5, 300.0, 150.0, 'fusil.png', 0, 0, 'arme', '12mm', '', '', 0, 500);
call CreateItem('Arc', 'Un arc pour la chasse', 2, 150.0, 75.0, 'arc.png', 10, 0, 'arme', '60', 'Arc', '', 0, 10);
call CreateItem('Plastron en cuir', 'Un plastron en cuir pour la protection', 4, 100.0, 50.0, 'plastron.png', 10, 0, 'armure', 'Cuir', 'Moyen', '', 0, 40);
call CreateItem('Baume de guerison', 'Un baume pour soigner les blessures', 1, 70.0, 35.0, 'baume.png', 255, 0, 'med', 'Soigne les blessures', 'Application locale', 'Aucun', 25, 25);
call CreateItem('Carotte', 'Une carotte fraîche et croquante', 1, 5.0, 2.5, 'carotte.png', 250, 0, 'food', '30 kcal', 'Vitamines', 'Mineraux', 10, 100);
call CreateItem('Carotte malefique', 'Une carotte fraîche et malefique', 1, 5.0, 2.5, 'carotteMalefique.png', 250, 0, 'food', 'maleficisim', 'Vitamines', 'Mineraux', -10, 100);
call CreateItem('Grenade', 'Une grenade explosive', 1, 50.0, 25.0, 'grenade.png', 0, 0, 'mun', 'Explosif', '', '', 0, 200);
call CreateItem('Lance', 'Une lance pour les combats rapproches', 6, 180.0, 90.0, 'lance.png', 15, 0, 'arme', '65', 'Lance', '', 0, 8);
call CreateItem('Gants en maille', 'Des gants en maille pour la protection', 1, 50.0, 25.0, 'gants.png', 5, 0, 'armure', 'Maille', 'Petit', '', 0, 60);
call CreateItem('Serum de regeneration', 'Un serum pour regenerer les cellules', 1, 100.0, 50.0, 'serum.png', 255, 0, 'med', 'Regenere les cellules', 'Injection', 'Aucun', 125, 10);
call CreateItem('Steak', 'Un steak juteux et savoureux', 2, 30.0, 15.0, 'steak.png', 250, 0, 'food', '250 kcal', 'Proteines', 'Fer', 20, 20);
call CreateItem('Fleche', 'Une fleche', 1, 2.0, 1.0, 'fleche.png', 0, 0, 'mun', 'Fleche', '', '', 0, 1000);
call CreateItem('Dague', 'Une dague legere et tranchante', 1, 80.0, 40.0, 'dague.png', 10, 0, 'arme', '55', 'Dague', '', 0, 15);
call CreateItem('Bouclier en fer', 'Un bouclier solide en fer', 5, 200.0, 100.0, 'bouclier_fer.png', 20, 0, 'armure', 'Fer', 'Grand', '', 0, 30);
call CreateItem('Pommade antiseptique', 'Une pommade pour desinfecter les plaies', 1, 60.0, 30.0, 'pommade.png', 255, 0, 'med', 'Desinfecte les plaies', 'Application locale', 'Aucun', 15, 20);
call CreateItem('Banane', 'Une banane mûre et sucree', 1, 15.0, 7.5, 'banane.png', 250, 0, 'food', '90 kcal', 'Potassium', 'Vitamines', 5, 50);
call CreateItem('Couteau de lancer', 'Un couteau equilibre pour le lancer', 1, 40.0, 20.0, 'couteau_lancer.png', 10, 0, 'arme', '45', 'Couteau', '', 0, 25);
call CreateItem('Armure en titane', 'Une armure legere et resistante en titane', 10, 500.0, 250.0, 'armure_titane.png', 30, 0, 'armure', 'Titane', 'Tres grand', '', 0, 5);
call CreateItem('Kit de premiers secours', 'Un kit complet pour les premiers soins', 2, 150.0, 75.0, 'kit_secours.png', 255, 0, 'med', 'Soins complets', 'Portable', 'Aucun', 0, 10);
call CreateItem('Orange', 'Une orange juteuse et vitaminee', 1, 10.0, 5.0, 'orange.png', 250, 0, 'food', '60 kcal', 'Vitamines', 'Mineraux', 13, 80);
call CreateItem('Pistolet', 'Un pistolet de calibre 9mm', 3, 250.0, 125.0, 'pistolet.png', 0, 0, 'arme', '9mm', '', '', 0, 300);

call CreateItem('SuperHeavy Pistol', 'Un pistolet de calibre 900mm', 100, 500.0, 125.0, 'pistoletSH.png', 0, 0, 'mun', '9mm', '', '', 0, 300);
call CreateItem('SuperHeavy Pistol LW edition', 'Un pistolet de calibre 500mm', 50, 50.0, 125.0, 'pistoletSHLWE.png', 0, 0, 'mun', '9mm', '', '', 0, 30);
call CreateItem('Mort Instantanée', 'Un item qui cause une mort instantanée', 1, 1000.0, 500.0, 'mort_instantanee.png', 255, 0, 'med', 'Cause la mort', 'Instantané', 'la mort', -10000, 10);
call CreateItem('Super Gain de Vie', 'Un item qui donne 10 000 points de vie', 1, 5000.0, 2500.0, 'super_gain_vie.png', 255, 0, 'med', 'Donne 10 000 PV', 'Instantané', 'vivre une autre journer', 10000, 10);

-- joueurs
select CreateJoueur('je vins, je vus, je construit', 'bob', 'leBricoleur', 'passbob');

select CreateJoueur('joueur1', 'John', 'Doe', 'passjohn');
select CreateJoueur('joueur2', 'Jane', 'Smith', 'passjane');
select CreateJoueur('joueur3', 'Alice', 'Johnson', 'passalice');
select CreateJoueur('playerA', 'firstname', 'lastname', 'password');

-- evaluations 
call PostCommentaire(5, 2, 'Superbe !!', 4);
call PostCommentaire(5, 5, 'Épatant !!', 5);
call PostCommentaire(5, 3, 'Ce n''est pas incroyable...', 2);

-- call CreateCommentaireEvaluation(1, 1, 1, 'Tres bon produit !', 5);
-- call CreateCommentaireEvaluation(2, 2, 1, 'Pas mal, mais pourrait etre mieux.', 3);
-- call CreateCommentaireEvaluation(3, 3, 1, 'Je ne suis pas satisfait.', 1);

-- [ php exemples ] -- 

-- quelques exemples et un peu d'explications pour votre plaisir :>

-- Ajouter un item au panier
-- CALL AddItemToCart(1, 101, 2);
-- Ajoute l'item avec itemID 101 au panier du joueure avec joueureID 1, en quantite de 2.

-- Passer une commande
-- CALL PassCommande(1);
-- Passe une commande pour le joueure avec joueureID 1.

-- Supprimer un item du panier
-- CALL RemoveItemFromCart(1, 101);
-- Supprime l'item avec itemID 101 du panier du joueure avec joueureID 1.

-- Mettre à jour la quantite d'un item dans le panier
-- CALL UpdateCartItemQuantity(1, 101, 5);
-- Met à jour la quantite de l'item avec itemID 101 dans le panier du joueure avec joueureID 1 à 5.

-- Vider le panier
-- CALL ClearCart(1);
-- Vide le panier du joueure avec joueureID 1.

-- Obtenir le contenu du panier
-- CALL GetCartContents(1);
-- Recupere le contenu du panier du joueure avec joueureID 1.

-- Creer un joueure
-- CALL CreateJoueur('alias', 'nom', 'prenom');
-- Cree un nouveau joueure avec l'alias, le nom et le prenom specifies.

-- Mettre à jour les caps d'un joueure
-- CALL SetCaps(1, 500);
-- Met à jour les caps du joueure avec joueureID 1 à 500.

-- Creer un item                            poid , buy  , sell        utulitr, status                                       qt
-- CALL CreateItem('itemName', 'description', 10, 100.0, 50.0, 'imageLink', 1, 0, 'arme', 'efficiency', 'genre', 'calibre', 100);
-- Cree un nouvel item avec les details specifies. Dans cet exemple, l'item est de type 'arme'.

-- Supprimer un item
-- CALL DeleteItem(101);
-- Supprime l'item avec itemID 101.

-- Creer un commentaire
-- CALL CreateCommentaireEvaluation(101, 1, 'commentaire', 5, 0(pos));
-- Cree un commentaire pour l'item avec itemID 101 par le joueure avec joueureID 1, avec une evaluation de 5.

-- Supprimer un commentaire
-- CALL DeleteCommentaire(101, 1, 1);
-- Supprime le commentaire avec commentaireID 1 pour l'item avec itemID 101 par le joueure avec joueureID 1.

-- Creer une quete
-- CALL CreateQuest(1, 'question', 'reponse1', 1, 'reponse2', 0, 'reponse3', 0, 'reponse4', 0);
-- Cree une nouvelle quete avec les reponses specifiees. Dans cet exemple, la premiere reponse est correcte.

-- Supprimer une quete
-- CALL DeleteQuest(1);
-- Supprime la quete avec questID 1.

-- aperçu on moin d'info que details, details a tout genre apport calorique

-- Obtenir un aperçu d'un item dans le shop
-- CALL GetShopPreviewItem(101);
-- Recupere un aperçu de l'item avec itemID 101 dans le shop.

-- Obtenir les details d'un item dans le shop
-- CALL GetShopItem(101);
-- Recupere les details de l'item avec itemID 101 dans le shop.

-- Obtenir un aperçu d'un item dans l'inventaire
-- CALL GetInventoryPreviewItem(101);
-- Recupere un aperçu de l'item avec itemID 101 dans l'inventaire.

-- Obtenir les details d'un item dans l'inventaire
-- CALL GetInventoryItemD(101);
-- Recupere les details de l'item avec itemID 101 dans l'inventaire.

-- Obtenir les details d'un item
-- CALL GetItemDetails(101);
-- Recupere les details de l'item avec itemID 101.
