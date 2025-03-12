use dbknapsak9;

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
drop table if exists reponsesQuetes cascade;
drop table if exists listeQuetes cascade;
drop table if exists diffQuetes cascade;
drop table if exists item cascade;
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
    poidsMax int default 200 not null
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
    commentaireID int,
    
    foreign key (itemID) references item(itemID),
    foreign key (joueureID) references joueure(joueureID),
    primary key (itemID, joueureID, commentaireID),
    
    commentaire varchar(1200),
    evaluations smallint,  -- entre 1 et 5/10 ?
    
    constraint ck_Commentaire_Evaluation check(evaluations between 1 and 5)    
);

-- [ quetes ] --

create table diffQuetes
(
    diffID int not null primary key,
    difficultyName varchar(20) not null,

    nbCaps int not null
);

create table listeQuetes
(
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

-- [  VIEWS  ] --

-- shop
drop view if exists ShopPreview; -- preview info for shop
create view ShopPreview as
select itemName, poidItem, imageLink, buyPrice 
from shop
join item
on shop.itemID = item.itemID;

drop view if exists Shop;   -- all main info for all items in shop, but not the details ==> use la procedure stoquer pour
create view Shop as
select itemName, poidItem, utiliter, imageLink, buyPrice, qt 
from shop
join item
on shop.itemID = item.itemID;

-- cart
drop view if exists CartPreview; -- preview info for cart
create view CartPreview as
select itemName, poidItem, imageLink, buyPrice 
from cart
join item
on cart.itemID = item.itemID;

drop view if exists CartItems;   -- all main info for all items in cart, but not the details ==> use la procedure stoquer pour
create view CartItems as
select itemName, poidItem, utiliter, imageLink, buyPrice, qt 
from shop
join item
on shop.itemID = item.itemID;

-- inventaire

drop view if exists InventoryPreview;   -- preview info for inventory
create view InventoryPreview as
select itemName, poidItem, imageLink 
from inventaire
join item
on inventaire.itemID = item.itemID;

drop view if exists Inventory;  -- all in inventory of all joueurs
create view Inventory as
select 
    inventaire.joueureID,
    inventaire.itemID,
    inventaire.qt,
    item.itemName,
    item.description,
    item.poidItem,
    item.buyPrice,
    item.sellPrice,
    item.imageLink,
    item.utiliter,
    item.itemStatus
from inventaire
join item on inventaire.itemID = item.itemID;


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

-- au debut ici c juste pour pouvoir voir les items de tout 

-- tous a des version one item ou multiple items, peut demander l'id du joueur concerner

-- Shop Preview Item (One)
drop procedure if exists GetOneShopPreviewItem;
delimiter //
create procedure GetOneShopPreviewItem(in p_itemID int)
begin
    select * from ShopPreview where ShopPreview.itemID = p_itemID;
end;
//
delimiter ;

-- Shop Preview Items (All)
drop procedure if exists GetAllShopPreviewItems;
delimiter //
create procedure GetAllShopPreviewItems()
begin
    select * from ShopPreview;
end;
//
delimiter ;

-- Shop Item (One)
drop procedure if exists GetOneShopItem;
delimiter //
create procedure GetOneShopItem(in p_itemID int)
begin
    select *
    from Shop
    left join Arme on Arme.itemID = Shop.itemID
    left join Armure on Armure.itemID = Shop.itemID
    left join Medicaments on Medicaments.itemID = Shop.itemID
    left join Nourriture on Nourriture.itemID = Shop.itemID
    left join Munition on Munition.itemID = Shop.itemID
    where Shop.itemID = p_itemID;
end;
//
delimiter ;

-- Shop Items (All)
drop procedure if exists GetAllShopItems;
delimiter //
create procedure GetAllShopItems()
begin
    select *
    from Shop
    left join Arme on Arme.itemID = Shop.itemID
    left join Armure on Armure.itemID = Shop.itemID
    left join Medicaments on Medicaments.itemID = Shop.itemID
    left join Nourriture on Nourriture.itemID = Shop.itemID
    left join Munition on Munition.itemID = Shop.itemID;
end;
//
delimiter ;

-- Cart Preview Item (One)
drop procedure if exists GetOneCartPreviewItem;
delimiter //
create procedure GetOneCartPreviewItem(in p_itemID int, in p_joueureID int)
begin
    select * from CartPreview where CartPreview.itemID = p_itemID and CartPreview.joueureID = p_joueureID;
end;
//
delimiter ;

-- Cart Preview Items (All)
drop procedure if exists GetAllCartPreviewItems;
delimiter //
create procedure GetAllCartPreviewItems(in p_joueureID int)
begin
    select * from CartPreview where CartPreview.joueureID = p_joueureID;
end;
//
delimiter ;

-- Cart Item (One)
drop procedure if exists GetOneCartItem;
delimiter //
create procedure GetOneCartItem(in p_itemID int, in p_joueureID int)
begin
    select *
    from CartItems
    left join Arme on Arme.itemID = CartItems.itemID
    left join Armure on Armure.itemID = CartItems.itemID
    left join Medicaments on Medicaments.itemID = CartItems.itemID
    left join Nourriture on Nourriture.itemID = CartItems.itemID
    left join Munition on Munition.itemID = CartItems.itemID
    where CartItems.itemID = p_itemID and CartItems.joueureID = p_joueureID;
end;
//
delimiter ;

-- Cart Items (All)
drop procedure if exists GetAllCartItems;
delimiter //
create procedure GetAllCartItems(in p_joueureID int)
begin
    select *
    from CartItems
    left join Arme on Arme.itemID = CartItems.itemID
    left join Armure on Armure.itemID = CartItems.itemID
    left join Medicaments on Medicaments.itemID = CartItems.itemID
    left join Nourriture on Nourriture.itemID = CartItems.itemID
    left join Munition on Munition.itemID = CartItems.itemID
    where CartItems.joueureID = p_joueureID;
end;
//
delimiter ;

-- Inventory Preview Item (One)
drop procedure if exists GetOneInventoryPreviewItem;
delimiter //
create procedure GetOneInventoryPreviewItem(in p_itemID int, in p_joueureID int)
begin
    select * from InventoryPreview where InventoryPreview.itemID = p_itemID and InventoryPreview.joueureID = p_joueureID;
end;
//
delimiter ;

-- Inventory Preview Items (All)
drop procedure if exists GetAllInventoryPreviewItems;
delimiter //
create procedure GetAllInventoryPreviewItems(in p_joueureID int)
begin
    select * from InventoryPreview where InventoryPreview.joueureID = p_joueureID;
end;
//
delimiter ;

-- Inventory Item (One)
drop procedure if exists GetOneInventoryItem;
delimiter //
create procedure GetOneInventoryItem(in p_itemID int, in p_joueureID int)
begin
    select * 
    from Inventory 
    left join Arme on Arme.itemID = Inventory.itemID
    left join Armure on Armure.itemID = Inventory.itemID
    left join Medicaments on Medicaments.itemID = Inventory.itemID
    left join Nourriture on Nourriture.itemID = Inventory.itemID
    left join Munition on Munition.itemID = Inventory.itemID
    where Inventory.itemID = p_itemID and Inventory.joueureID = p_joueureID;
end;
//
delimiter ;

-- Inventory Items (All)
drop procedure if exists GetAllInventoryItems;
delimiter //
create procedure GetAllInventoryItems(in p_joueureID int)
begin
    select * 
    from Inventory 
    left join Arme on Arme.itemID = Inventory.itemID
    left join Armure on Armure.itemID = Inventory.itemID
    left join Medicaments on Medicaments.itemID = Inventory.itemID
    left join Nourriture on Nourriture.itemID = Inventory.itemID
    left join Munition on Munition.itemID = Inventory.itemID
    where Inventory.joueureID = p_joueureID;
end;
//
delimiter ;

-- Item Details (One)
drop procedure if exists GetOneItemDetails;
delimiter //
create procedure GetOneItemDetails(in p_itemID int)
begin
    select *
    from item
    left join Arme on Arme.itemID = item.itemID
    left join Armure on Armure.itemID = item.itemID
    left join Medicaments on Medicaments.itemID = item.itemID
    left join Nourriture on Nourriture.itemID = item.itemID
    left join Munition on Munition.itemID = item.itemID
    where item.itemID = p_itemID;
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
    left join Arme on Arme.itemID = item.itemID
    left join Armure on Armure.itemID = item.itemID
    left join Medicaments on Medicaments.itemID = item.itemID
    left join Nourriture on Nourriture.itemID = item.itemID
    left join Munition on Munition.itemID = item.itemID;
end;
//
delimiter ;





-- [ Procedures CRUD ] -- 

drop procedure if exists CreateJoueur;
delimiter //
create procedure CreateJoueur(
    in p_alias varchar(50),
    in p_nom varchar(50),
    in p_prenom varchar(50),
    in p_playerPassword varchar(50)
)
begin
    insert into joueure (alias, nom, prenom, playerPassword)
        values (p_alias, p_nom, p_prenom, SHA2(p_playerPassword, 256)); 
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

    in p_qt int
)
begin
    declare itemID int;
    
    insert into item (itemName, description, poidItem, buyPrice, sellPrice, imageLink, utiliter, itemStatus)
    values (p_itemName, p_description, p_poidItem, p_buyPrice, p_sellPrice, p_imageLink, p_utiliter, p_itemStatus);

    set itemID = LAST_INSERT_ID();

    if p_types = 'arme' then
        insert into Arme (itemID, efficiency, genre, calibre)
        values (itemID, p_details1, p_details2, p_details3);
    elseif p_types = 'armure' then
        insert into Armure (itemID, material, size)
        values (itemID, p_details1, p_details2);
    elseif p_types = 'med' then
        insert into Medicaments (itemID, effect, duration, unwantedEffect)
        values (itemID, p_details1, p_details2, p_details3);
    elseif p_types = 'food' then
        insert into Nourriture (itemID, apportCalorique, composantNutritivePrincipale, mineralPrincipale)
        values (itemID, p_details1, p_details2, p_details3);
    elseif p_types = 'mun' then
        insert into Munition (itemID, calibre)
        values (itemID, p_details1);
    end if;

    if p_itemStatus = 0 or p_itemStatus = 1 then
        insert into shop(itemID, qt)
        values(itemID, p_qt);
    end if;
end;
//
delimiter ;

drop procedure if exists DeleteItem;
delimiter //
create procedure DeleteItem(in p_itemID int)
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

drop procedure if exists UseItem;
delimiter //
create procedure UseItem(in p_itemID int, in p_joueureID int)
begin
    declare healthGain int;
    declare itemQT int;

    select qt into itemQT
    from inventaire
    where itemID = p_itemID and joueureID = p_joueureID;

    select healthGain into healthGain
    from Medicaments
    where itemID = p_itemID;

    if healthGain is null then
        select healthGain into healthGain
        from Nourriture
        where itemID = p_itemID;
    end if;

    if healthGain is not null then
        update joueure
        set pv = pv + healthGain
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

-- login/passwords

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
create procedure ChangePassword(in p_alias varchar(50), in p_playerPassword varchar(50))
begin
    update joueure
    set playerPassword = SHA2(p_playerPassword, 256)
    where alias = p_alias;
end;
//
delimiter ;

-- commentaire

drop procedure if exists CreateCommentaireEvaluation;
delimiter //
create procedure CreateCommentaireEvaluation(
    in p_itemID int,
    in p_joueureID int,
    in p_commentaireID int,
    in p_commentaire varchar(1200),
    in p_evaluations smallint
)
begin
    if exists(select 1 from commentaires where itemID = p_itemID and joueureID = p_joueureID and commentaireID = p_commentaireID limit 1) then
        insert into commentaires (itemID, joueureID, commentaireID, commentaire, evaluations)
        values (p_itemID, p_joueureID, p_commentaireID, p_commentaire, p_evaluations);
    end if;
end;
//
delimiter ;

drop procedure if exists DeleteCommentaire;
delimiter //
create procedure DeleteCommentaire(in p_itemID int, in p_joueureID int, in p_commentaireID int)
begin
    delete from commentaires where itemID = p_itemID and joueureID = p_joueureID and commentaireID = p_commentaireID;
end;
//
delimiter ;

drop procedure if exists GetEval;
delimiter //
create procedure GetEval(in p_itemID int, in p_joueureID int)
begin
    select evaluations from commentaire where itemID = p_itemID and joueureID = p_joueureID and evaluations is not null limit 1;
end;
//
delimiter ;

drop function if exists GetAverageEval;
delimiter //
create function GetAverageEval(p_itemID int)
returns decimal(10,2)
begin
    declare avgEval decimal(10,2);
    select avg(evaluations) into avgEval
    from commentaire
    where itemID = p_itemID and evaluations is not null;
    return avgEval;
end;
//
delimiter ;

-- quest
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

drop procedure if exists DoQuest; -- utiliser pour checker si la reponse est la bonne et donner les caps
delimiter //
create procedure DoQuest(
    in p_questID int,
    in p_joueureID int,
    in p_answerID int
)
begin
    declare correctAnswerExists boolean;
    declare reward int;

    select exists (select 1 from reponsesQuetes where questID = p_questID and awnserID = p_answerID and flagEstVrai = 1) into correctAnswerExists;

    if correctAnswerExists then
        select dq.nbCaps into reward
        from listeQuetes lq
        join diffQuetes dq on lq.diffID = dq.diffID
        where lq.questID = questID;

        update joueure
        set caps = caps + reward
        where joueureID = joueureID;
    else
        signal sqlstate '45000' set message_text = 'Incorrect answer';
    end if;
end;
//
delimiter ;

-- cart

drop procedure if exists AddItemToCart;
delimiter //
create procedure AddItemToCart(
    in p_joueureID int,
    in p_itemID int,
    in p_quantity int
)
begin
    if exists (select 1 from cart where joueureID = p_joueureID and itemID = p_itemID) then
        update cart
        set qt = qt + p_quantity
        where joueureID = p_joueureID and itemID = p_itemID;
    else
        insert into cart (joueureID, itemID, qt)
        values (p_joueureID, p_itemID, p_quantity);
    end if;
end;
//
delimiter ;

drop procedure if exists PassCommande;
delimiter //
create procedure PassCommande(
    in p_joueureID int
)
begin
    declare totalCost decimal(10,2);
    
    select sum(c.qt * i.buyPrice) into totalCost
    from cart c
    join item i on c.itemID = i.itemID
    where c.joueureID = p_joueureID;
    
    if exists (select 1 from joueure where joueureID = p_joueureID and caps >= totalCost) then
        update joueure
        set caps = caps - totalCost
        where joueureID = p_joueureID;
        
        insert into inventaire (joueureID, itemID, qt)
        select joueureID, itemID, qt from cart where joueureID = p_joueureID; -- todo repeat thingy??
        
        delete from cart where joueureID = p_joueureID;
    else
        signal sqlstate '45000' set message_text = 'Insufficient caps to complete the purchase'; -- check manque items dans shop
    end if;
end;

//
delimiter ;
drop procedure if exists RemoveItemFromCart;
delimiter //
create procedure RemoveItemFromCart(
    in p_joueureID int,
    in p_itemID int
)
begin
    delete from cart where joueureID = p_joueureID and itemID = p_itemID;
end;
//
delimiter ;

drop procedure if exists UpdateCartItemQuantity;
delimiter //
create procedure UpdateCartItemQuantity(
    in p_joueureID int,
    in p_itemID int,
    in p_quantity int
)
begin
    update cart
    set qt = p_quantity
    where joueureID = p_joueureID and itemID = p_itemID;
end;
//
delimiter ;

drop procedure if exists ClearCart;
delimiter //
create procedure ClearCart(
    in p_joueureID int
)
begin
    delete from cart where joueureID = p_joueureID;
end;
//
delimiter ;

drop procedure if exists GetCartContents;
delimiter //
create procedure GetCartContents(
    in p_joueureID int
)
begin
    select cart.itemID, item.itemName, cart.qt, item.buyPrice, (cart.qt * item.buyPrice) as totalPrice
    from cart
    join item on cart.itemID = item.itemID
    where cart.joueureID = p_joueureID;
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

-- Difficultes des quêtes
insert into diffQuetes (diffID, difficultyName, nbCaps) values (1, 'facile', 10), (2, 'moyen', 100), (3, 'difficile', 1000);

-- Quêtes
call CreateQuest(1, 'Quelle est la couleur du ciel ?', 'Bleu', 1, 'Vert', 0, 'Rouge', 0, 'Jaune', 0);
call CreateQuest(2, 'Combien de pattes a un chien ?', '2', 0, '4', 1, '6', 0, '8', 0);
call CreateQuest(3, 'Quelle est la capitale de la France ?', 'Berlin', 0, 'Madrid', 0, 'Paris', 1, 'Rome', 0);

-- items
call CreateItem('Epee de base', 'Une epee simple pour les debutants', 5, 100.0, 50.0, 'epee.png', 10, 0, 'arme', '50', 'Epee', '', 10);
call CreateItem('Bouclier de base', 'Un bouclier simple pour les debutants', 7, 150.0, 75.0, 'bouclier.png', 10, 0, 'armure', 'Bois', 'Moyen', '', 100);
call CreateItem('Potion de soin', 'Une potion qui soigne 50 PV', 1, 50.0, 25.0, 'potion.png', 255, 0, 'med', 'Soigne 50 PV', 'Instantane', 'Aucun', 15);
call CreateItem('Pomme', 'Une pomme fraîche', 1, 10.0, 5.0, 'pomme.png', 250, 0, 'food', '50 kcal', 'Vitamines', 'Mineraux', 50);
call CreateItem('Balle', 'Une balle de calibre 9mm', 1, 1.0, 0.5, 'balle.png', 0, 0, 'mun', '9mm', '', '', 1000);

-- Nouveaux items
call CreateItem('Hache de guerre', 'Une hache puissante pour les combats', 8, 200.0, 100.0, 'hache.png', 20, 0, 'arme', '70', 'Hache', '', 5);
call CreateItem('Casque en acier', 'Un casque robuste pour la protection', 3, 120.0, 60.0, 'casque.png', 15, 0, 'armure', 'Acier', 'Grand', '', 50);
call CreateItem('Antidote', 'Un remede contre les poisons', 1, 80.0, 40.0, 'antidote.png', 255, 0, 'med', 'Guerit les poisons', 'Instantane', 'Aucun', 20);
call CreateItem('Pain', 'Un pain frais et nourrissant', 2, 20.0, 10.0, 'pain.png', 250, 0, 'food', '200 kcal', 'Glucides', 'Fibres', 30);
call CreateItem('Fusil', 'Un fusil de calibre 12', 5, 300.0, 150.0, 'fusil.png', 0, 0, 'mun', '12mm', '', '', 500);
call CreateItem('Arc', 'Un arc pour la chasse', 2, 150.0, 75.0, 'arc.png', 10, 0, 'arme', '60', 'Arc', '', 10);
call CreateItem('Plastron en cuir', 'Un plastron en cuir pour la protection', 4, 100.0, 50.0, 'plastron.png', 10, 0, 'armure', 'Cuir', 'Moyen', '', 40);
call CreateItem('Baume de guerison', 'Un baume pour soigner les blessures', 1, 70.0, 35.0, 'baume.png', 255, 0, 'med', 'Soigne les blessures', 'Application locale', 'Aucun', 25);
call CreateItem('Carotte', 'Une carotte fraîche et croquante', 1, 5.0, 2.5, 'carotte.png', 250, 0, 'food', '30 kcal', 'Vitamines', 'Mineraux', 100);
call CreateItem('Grenade', 'Une grenade explosive', 1, 50.0, 25.0, 'grenade.png', 0, 0, 'mun', 'Explosif', '', '', 200);
call CreateItem('Lance', 'Une lance pour les combats rapproches', 6, 180.0, 90.0, 'lance.png', 15, 0, 'arme', '65', 'Lance', '', 8);
call CreateItem('Gants en maille', 'Des gants en maille pour la protection', 1, 50.0, 25.0, 'gants.png', 5, 0, 'armure', 'Maille', 'Petit', '', 60);
call CreateItem('Serum de regeneration', 'Un serum pour regenerer les cellules', 1, 100.0, 50.0, 'serum.png', 255, 0, 'med', 'Regenere les cellules', 'Injection', 'Aucun', 10);
call CreateItem('Steak', 'Un steak juteux et savoureux', 2, 30.0, 15.0, 'steak.png', 250, 0, 'food', '250 kcal', 'Proteines', 'Fer', 20);
call CreateItem('Fleche', 'Une fleche', 1, 2.0, 1.0, 'fleche.png', 0, 0, 'mun', 'Fleche', '', '', 1000);
call CreateItem('Dague', 'Une dague legere et tranchante', 1, 80.0, 40.0, 'dague.png', 10, 0, 'arme', '55', 'Dague', '', 15);
call CreateItem('Bouclier en fer', 'Un bouclier solide en fer', 5, 200.0, 100.0, 'bouclier_fer.png', 20, 0, 'armure', 'Fer', 'Grand', '', 30);
call CreateItem('Pommade antiseptique', 'Une pommade pour desinfecter les plaies', 1, 60.0, 30.0, 'pommade.png', 255, 0, 'med', 'Desinfecte les plaies', 'Application locale', 'Aucun', 20);
call CreateItem('Banane', 'Une banane mûre et sucree', 1, 15.0, 7.5, 'banane.png', 250, 0, 'food', '90 kcal', 'Potassium', 'Vitamines', 50);
call CreateItem('Couteau de lancer', 'Un couteau equilibre pour le lancer', 1, 40.0, 20.0, 'couteau_lancer.png', 10, 0, 'arme', '45', 'Couteau', '', 25);
call CreateItem('Armure en titane', 'Une armure legere et resistante en titane', 10, 500.0, 250.0, 'armure_titane.png', 30, 0, 'armure', 'Titane', 'Tres grand', '', 5);
call CreateItem('Kit de premiers secours', 'Un kit complet pour les premiers soins', 2, 150.0, 75.0, 'kit_secours.png', 255, 0, 'med', 'Soins complets', 'Portable', 'Aucun', 10);
call CreateItem('Orange', 'Une orange juteuse et vitaminee', 1, 10.0, 5.0, 'orange.png', 250, 0, 'food', '60 kcal', 'Vitamines', 'Mineraux', 80);
call CreateItem('Pistolet', 'Un pistolet de calibre 9mm', 3, 250.0, 125.0, 'pistolet.png', 0, 0, 'mun', '9mm', '', '', 300);

-- joueurs
call CreateJoueur('je vins, je vus, je construit', 'bob', 'leBricoleur', 'passbob');

call CreateJoueur('joueur1', 'John', 'Doe', 'passjohn');
call CreateJoueur('joueur2', 'Jane', 'Smith', 'passjane');
call CreateJoueur('joueur3', 'Alice', 'Johnson', 'passalice');

-- evaluations 
call CreateCommentaireEvaluation(1, 1, 1, 'Tres bon produit !', 5);
call CreateCommentaireEvaluation(2, 2, 1, 'Pas mal, mais pourrait être mieux.', 3);
call CreateCommentaireEvaluation(3, 3, 1, 'Je ne suis pas satisfait.', 1);

-- [ php exemples ] -- 

-- quelques exemples et un peu d'explications pour votre plaisir :>

-- Ajouter un item au panier
-- CALL AddItemToCart(1, 101, 2);
-- Ajoute l'item avec itemID 101 au panier du joueur avec joueureID 1, en quantite de 2.

-- Passer une commande
-- CALL PassCommande(1);
-- Passe une commande pour le joueur avec joueureID 1.

-- Supprimer un item du panier
-- CALL RemoveItemFromCart(1, 101);
-- Supprime l'item avec itemID 101 du panier du joueur avec joueureID 1.

-- Mettre à jour la quantite d'un item dans le panier
-- CALL UpdateCartItemQuantity(1, 101, 5);
-- Met à jour la quantite de l'item avec itemID 101 dans le panier du joueur avec joueureID 1 à 5.

-- Vider le panier
-- CALL ClearCart(1);
-- Vide le panier du joueur avec joueureID 1.

-- Obtenir le contenu du panier
-- CALL GetCartContents(1);
-- Recupere le contenu du panier du joueur avec joueureID 1.

-- Creer un joueur
-- CALL CreateJoueur('alias', 'nom', 'prenom');
-- Cree un nouveau joueur avec l'alias, le nom et le prenom specifies.

-- Mettre à jour les caps d'un joueur
-- CALL SetCaps(1, 500);
-- Met à jour les caps du joueur avec joueureID 1 à 500.

-- Creer un item                            poid , buy  , sell        utulitr, status                                       qt
-- CALL CreateItem('itemName', 'description', 10, 100.0, 50.0, 'imageLink', 1, 0, 'arme', 'efficiency', 'genre', 'calibre', 100);
-- Cree un nouvel item avec les details specifies. Dans cet exemple, l'item est de type 'arme'.

-- Supprimer un item
-- CALL DeleteItem(101);
-- Supprime l'item avec itemID 101.

-- Creer un commentaire
-- CALL CreateCommentaireEvaluation(101, 1, 'commentaire', 5, 0(pos));
-- Cree un commentaire pour l'item avec itemID 101 par le joueur avec joueureID 1, avec une evaluation de 5.

-- Supprimer un commentaire
-- CALL DeleteCommentaire(101, 1, 1);
-- Supprime le commentaire avec commentaireID 1 pour l'item avec itemID 101 par le joueur avec joueureID 1.

-- Creer une quête
-- CALL CreateQuest(1, 'question', 'reponse1', 1, 'reponse2', 0, 'reponse3', 0, 'reponse4', 0);
-- Cree une nouvelle quête avec les reponses specifiees. Dans cet exemple, la premiere reponse est correcte.

-- Supprimer une quête
-- CALL DeleteQuest(1);
-- Supprime la quête avec questID 1.

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
