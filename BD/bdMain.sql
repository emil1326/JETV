-- Drop tables if they exist
drop table if exists joueure cascade;
drop table if exists cart cascade;
drop table if exists inventaire cascade;
drop table if exists shop cascade;
drop table if exists item cascade;
drop table if exists Arme cascade;
drop table if exists Armure cascade;
drop table if exists Medicaments cascade;
drop table if exists Nourriture cascade;
drop table if exists Munition cascade;
drop table if exists commentaires cascade;
drop table if exists listeQuetes cascade;
drop table if exists diffQuetes cascade;
drop table if exists reponsesQuetes cascade;

-- [ tables ] --

-- [ joueure ] -- 

create table joueure
(
    joueureID int generated by default as identity,
    
    alias varchar(50),
    nom varchar(50) not null,
    prenom varchar(50) not null,
    caps int default 1000 not null,
    dexteriter int default 100 not null,
    pv int default 100 not null,
    poidsMax int default 200 not null
);

create table cart
(
    joueureID int, 
    itemID int,
    
    primary key (joueureID, itemID),
    
    qt int not null 
);

create table inventaire
(
    joueureID int,
    itemID int,
    
    primary key (joueureID, itemID),
    
    qt int not null
);

-- [ items ] --

create table shop
(
    itemID int not null,
    
    foreign key (itemID) references item(itemID),
    
    qt int -- if null => infini
);

create table item
(
    itemID int generated by default as identity,
    itemName varchar(50) not null,
    
    description varchar(500),
    poidItem int not null,
    buyPrice int,
    sellPrice int,        -- returns error si null, si null peu pas achat/vendre donc faut griser le bouton
    imageLink varchar(100),
    utiliter tinyint default 0 not null, -- 0-255
    itemStatus tinyint default 0 not null, -- 0 = normal, 1 : inventory disabled, 2: shop diabled, 3: shop && inventory disabled 
    
    constraint ck_Item_ItemStatus check(itemStatus between 0 and 4)
);

-- item types

create table Arme
(
    itemID int not null,
    
    foreign key (itemID) references item(itemID),
    
    efficiency varchar(50),
    genre varchar(50),
    calibre varchar(50)
);

create table Armure
(
    itemID int not null,
    
    foreign key (itemID) references item(itemID),
    
    material varchar(50),
    size varchar(50)
);

create table Medicaments
(
    itemID int not null,
    
    foreign key (itemID) references item(itemID),
    
    effect varchar(50),
    duration varchar(50),
    unwantedEffect varchar(50)
);

create table Nourriture
(
    itemID int not null,
    
    foreign key (itemID) references item(itemID),
    
    apportCalorique varchar(50),
    composantNutritivePrincipale varchar(50),
    mineralPrincipale varchar(50)
);

create table Munition
(
    itemID int not null,
    
    foreign key (itemID) references item(itemID),
    
    calibre varchar(50)
);

--

create table commentaires
(
    itemID int,
    playerID int,
    commentaireID int,
    
    foreign key (itemID) references item(itemID),
    foreign key (playerID) references joueure(joueureID),
    primary key (itemID, playerID, commentaireID),
    
    commentaire varchar(1200),
    evaluations smallint,  -- entre 1 et 5/10 ?
    
    constraint ck_Commentaire_Evaluation check(evaluations between 1 and 5)    
);

-- [ quetes ] --

create table listeQuetes
(
    questID int generated by default as identity,
    diffID int not null,
    
    foreign key (diffID) references diffQuetes(diffID),
    
    question varchar(200) not null
);

create table diffQuetes
(
    diffID int not null primary key,
    difficultyName varchar(20) not null
);

create table reponsesQuetes
(
    awnserID int generated by default as identity,
    questID int not null,

    foreign key (questID) references listeQuetes(questID),
    
    reponse varchar(200) not null,
    flagEstVrai smallint not null default 0,
    
    constraint ck_reponsesQuetes_flagEstVrai check(flagEstVrai between 0 and 1) -- stay entre 0 et 1 pour le flag 0=> false
);

-- [  VIEWS  ] --

-- shop

create or alter view ShopPreview as
select itemName, poidItem, imageLink, buyPrice 
from shop
join item
on shop.itemID = item.itemID;

create or alter view Shop as
select itemName, poidItem, utiliter, imageLink, buyPrice, qt 
from shop
join item
on shop.itemID = item.itemID;

-- inventaire

create or alter view InventoryPreview as
select itemName, poidItem, imageLink 
from inventaire
join item
on inventaire.itemID = item.itemID;

create or alter view Inventory as
select *
from inventaire
join item
on inventaire.itemID = item.itemID;


-- [ SELECTS ] --

-- Quests
select * from listeQuetes order by random() limit 1;
select * from listeQuetes;

-- Cart
select * from cart where joueureID = ?;

-- Joueure
select * from joueure where joueureID = ?;
select caps from joueure where joueureID = ?;

-- Commentaires
select * from commentaires where itemID = ?;
select avg(evaluations) as moyenne_etoiles from commentaires where itemID = ?;


-- [ PROCEDURES ] --

create or alter procedure GetShopPreviewItem(@itemID int)
as
begin
    select * from ShopPreview where itemID = @itemID;
end;

create or alter procedure GetShopItem(@itemID int)
as
begin
    select *
    from Shop
    join Arme on Arme.itemID = @itemID
    join Armure on Armure.itemID = @itemID
    join Medicaments on Medicaments.itemID = @itemID
    join Nourriture on Nourriture.itemID = @itemID
    join Munition on Munition.itemID = @itemID
    where Shop.itemID = @itemID;
end;

create or alter procedure GetInventoryPreviewItem(@itemID int)
as
begin
    select * from InventoryPreview where itemID = @itemID;
end;

create or alter procedure GetInventoryItemD(@itemID int)
as
begin
    select * 
    from Inventory 
    left join Arme on Arme.itemID = @itemID
    left join Armure on Armure.itemID = @itemID
    left join Medicaments on Medicaments.itemID = @itemID
    left join Nourriture on Nourriture.itemID = @itemID
    left join Munition on Munition.itemID = @itemID
    where Inventory.itemID = @itemID;
end;

create or alter procedure GetItemDetails(@itemID int)
as
begin
    select *
    from item
    left join Arme on Arme.itemID = @itemID
    left join Armure on Armure.itemID = @itemID
    left join Medicaments on Medicaments.itemID = @itemID
    left join Nourriture on Nourriture.itemID = @itemID
    left join Munition on Munition.itemID = @itemID
    where item.itemID = @itemID;
end;

-- [ Procedures CRUD ] -- 

create or alter procedure CreateJoueur(
    @alias varchar(50),
    @nom varchar(50),
    @prenom varchar(50)
)
as
begin
    declare @joueureID int;
    
    insert into joueure (alias, nom, prenom)
    values (@alias, @nom, @prenom);
end;

create or alter procedure SetCaps(@joueureID int, @amount int)
as
begin
    update joueure set caps = @amount where joueureID = @joueureID;
end

create or alter procedure CreateItem(
    @itemName varchar(50),
    @description varchar(500),
    @poidItem int,
    @buyPrice int,
    @sellPrice int,
    @imageLink varchar(100),
    @utiliter tinyint,
    @itemStatus tinyint,

    @types varchar(10), -- => arme, armure, med, food, mun

    @details1 varchar(50),
    @details2 varchar(50),
    @details3 varchar(50),       -- => juste pour display de quoi dedans les classes

    @qt int
)
as
begin
    declare @itemID int;
    
    insert into item (itemName, description, poidItem, buyPrice, sellPrice, imageLink, utiliter, itemStatus)
    values (@itemName, @description, @poidItem, @buyPrice, @sellPrice, @imageLink, @utiliter, @itemStatus);

    set @itemID = scope_identity();

    if @types = 'arme'
    begin
        insert into Arme (itemID, efficiency, genre, calibre)
        values (@itemID, @details1, @details2, @details3);
    end
    else if @types = 'armure'
    begin
        insert into Armure (itemID, material, size)
        values (@itemID, @details1, @details2);
    end
    else if @types = 'med'
    begin
        insert into Medicaments (itemID, effect, duration, unwantedEffect)
        values (@itemID, @details1, @details2, @details3);
    end
    else if @types = 'food'
    begin
        insert into Nourriture (itemID, apportCalorique, composantNutritivePrincipale, mineralPrincipale)
        values (@itemID, @details1, @details2, @details3);
    end
    else if @types = 'mun'
    begin
        insert into Munition (itemID, calibre)
        values (@itemID, @details1);
    end

    if @itemStatus = 0 or @itemStatus = 1
    begin
        insert into shop(itemID, qt)
        values(@itemID, @qt)
    end
end;

create or alter procedure DeleteItem(@itemID int)
as
begin
    delete from item where itemID = @itemID;

    delete from Arme where itemID = @itemID;
    delete from Armure where itemID = @itemID;
    delete from Medicaments where itemID = @itemID;
    delete from Nourriture where itemID = @itemID;
    delete from Munition where itemID = @itemID;
end;

-- commentaire

create or alter procedure CreateCommentaireEvaluation(
    @itemID int,
    @playerID int,
    @commentaire varchar(1200),
    @evaluations smallint
)
as
begin
    insert into commentaires (itemID, playerID, commentaire, evaluations)
    values (@itemID, @playerID, @commentaire, @evaluations);
end;

create or alter procedure DeleteCommentaire(@itemID int, @playerID int, @commentaireID int)
as
begin
    delete from commentaires where itemID = @itemID and playerID = @playerID and commentaireID = @commentaireID;
end;

-- quest

create or alter procedure CreateQuest(
    @diffID int,
    @question varchar(200),
    @reponse1 varchar(200), 
    @flagEstVrai1 smallint,
    @reponse2 varchar(200), 
    @flagEstVrai2 smallint,
    @reponse3 varchar(200), 
    @flagEstVrai3 smallint,
    @reponse4 varchar(200), 
    @flagEstVrai4 smallint
)
as
begin
    declare @questID int;
    
    insert into listeQuetes (diffID, question)
    values (@diffID, @question);
    
    set @questID = scope_identity();
    
    insert into reponsesQuetes (questID, reponse, flagEstVrai)
    values 
    (@questID, @reponse1, @flagEstVrai1),
    (@questID, @reponse2, @flagEstVrai2),
    (@questID, @reponse3, @flagEstVrai3),
    (@questID, @reponse4, @flagEstVrai4);

end;

create or alter procedure DeleteQuest(@questID int)
as
begin
    delete from reponsesQuetes where questID = @questID;
    delete from listeQuetes where questID = @questID;
end;

-- cart

create or alter procedure AddItemToCart(
    @joueureID int,
    @itemID int,
    @quantity int
)
as
begin
    if exists (select 1 from cart where joueureID = @joueureID and itemID = @itemID) -- si deja dedans le cart
    begin
        update cart
        set qt = qt + @quantity
        where joueureID = @joueureID and itemID = @itemID;
    end
    else
    begin
        insert into cart (joueureID, itemID, qt)
        values (@joueureID, @itemID, @quantity);
    end
end;

create or alter procedure PassCommande(
    @joueureID int
)
as
begin
    declare @totalCost int;
    
    select @totalCost = sum(c.qt * i.buyPrice)
    from cart c
    join item i on c.itemID = i.itemID
    where c.joueureID = @joueureID;
    
    if exists (select 1 from joueure where joueureID = @joueureID and caps >= @totalCost)
    begin
        update joueure
        set caps = caps - @totalCost
        where joueureID = @joueureID;
        
        insert into inventaire (joueureID, itemID, qt)
        select joueureID, itemID, qt from cart where joueureID = @joueureID;
        
        delete from cart where joueureID = @joueureID;
    end
    else
    begin
        raiserror('Insufficient caps to complete the purchase', 16, 1);
    end
end;

create or alter procedure RemoveItemFromCart(
    @joueureID int,
    @itemID int
)
as
begin
    delete from cart where joueureID = @joueureID and itemID = @itemID;
end;

create or alter procedure UpdateCartItemQuantity(
    @joueureID int,
    @itemID int,
    @quantity int
)
as
begin
    update cart
    set qt = @quantity
    where joueureID = @joueureID and itemID = @itemID;
end;

create or alter procedure ClearCart(
    @joueureID int
)
as
begin
    delete from cart where joueureID = @joueureID;
end;

create or alter procedure GetCartContents(
    @joueureID int
)
as
begin
    select cart.itemID, item.itemName, cart.qt, item.buyPrice, (cart.qt * item.buyPrice) as totalPrice
    from cart
    join item on cart.itemID = item.itemID
    where cart.joueureID = @joueureID;
end;


-- [ DEFAULT DATA ] --

-- Difficultés des quêtes
insert into diffQuetes (diffID, difficultyName) values (1, 'facile'), (2, 'moyen'), (3, 'difficile');

-- Quêtes
exec CreateQuest(1, 'Quelle est la couleur du ciel ?', 'Bleu', 1, 'Vert', 0, 'Rouge', 0, 'Jaune', 0);
exec CreateQuest(2, 'Combien de pattes a un chien ?', '2', 0, '4', 1, '6', 0, '8', 0);
exec CreateQuest(3, 'Quelle est la capitale de la France ?', 'Berlin', 0, 'Madrid', 0, 'Paris', 1, 'Rome', 0);

-- items
exec CreateItem('Epée de base', 'Une épée simple pour les débutants', 5, 100.0, 50.0, 'epee.png', 10, 0, 'arme', '50', 'Epée', '', 10);

exec CreateItem('Bouclier de base', 'Un bouclier simple pour les débutants', 7, 150.0, 75.0, 'bouclier.png', 10, 0, 'armure', 'Bois', 'Moyen', '', 100);

exec CreateItem('Potion de soin', 'Une potion qui soigne 50 PV', 1, 50.0, 25.0, 'potion.png', 255, 0, 'med', 'Soigne 50 PV', 'Instantané', 'Aucun', 15);

exec CreateItem('Pomme', 'Une pomme fraîche', 1, 10.0, 5.0, 'pomme.png', 250, 0, 'food', '50 kcal', 'Vitamines', 'Minéraux', 50);

exec CreateItem('Balle', 'Une balle de calibre 9mm', 1, 1.0, 0.5, 'balle.png', 0, 0, 'mun', '9mm', '', '', 1000);

-- joueurs
exec CreateJoueur('je vins, je vus, je construit', 'bob', 'leBricoleur');

exec CreateJoueur('joueur1', 'John', 'Doe');
exec CreateJoueur('joueur2', 'Jane', 'Smith');
exec CreateJoueur('joueur3', 'Alice', 'Johnson');

-- evaluations 
exec CreateCommentaireEvaluation(1, 1, 'Très bon produit !', 5);
exec CreateCommentaireEvaluation(2, 2, 'Pas mal, mais pourrait être mieux.', 3);
exec CreateCommentaireEvaluation(3, 3, 'Je ne suis pas satisfait.', 1);

-- [ php exemples ] -- 

-- quelques exemples et un peu d'explications pour votre plaisir :>

-- Ajouter un item au panier
-- CALL AddItemToCart(1, 101, 2);
-- Ajoute l'item avec itemID 101 au panier du joueur avec joueureID 1, en quantité de 2.

-- Passer une commande
-- CALL PassCommande(1);
-- Passe une commande pour le joueur avec joueureID 1.

-- Supprimer un item du panier
-- CALL RemoveItemFromCart(1, 101);
-- Supprime l'item avec itemID 101 du panier du joueur avec joueureID 1.

-- Mettre à jour la quantité d'un item dans le panier
-- CALL UpdateCartItemQuantity(1, 101, 5);
-- Met à jour la quantité de l'item avec itemID 101 dans le panier du joueur avec joueureID 1 à 5.

-- Vider le panier
-- CALL ClearCart(1);
-- Vide le panier du joueur avec joueureID 1.

-- Obtenir le contenu du panier
-- CALL GetCartContents(1);
-- Récupère le contenu du panier du joueur avec joueureID 1.

-- Créer un joueur
-- CALL CreateJoueur('alias', 'nom', 'prenom');
-- Crée un nouveau joueur avec l'alias, le nom et le prénom spécifiés.

-- Mettre à jour les caps d'un joueur
-- CALL SetCaps(1, 500);
-- Met à jour les caps du joueur avec joueureID 1 à 500.

-- Créer un item                            poid , buy  , sell        utulitr, status                                       qt
-- CALL CreateItem('itemName', 'description', 10, 100.0, 50.0, 'imageLink', 1, 0, 'arme', 'efficiency', 'genre', 'calibre', 100);
-- Crée un nouvel item avec les détails spécifiés. Dans cet exemple, l'item est de type 'arme'.

-- Supprimer un item
-- CALL DeleteItem(101);
-- Supprime l'item avec itemID 101.

-- Créer un commentaire
-- CALL CreateCommentaireEvaluation(101, 1, 'commentaire', 5);
-- Crée un commentaire pour l'item avec itemID 101 par le joueur avec joueureID 1, avec une évaluation de 5.

-- Supprimer un commentaire
-- CALL DeleteCommentaire(101, 1, 1);
-- Supprime le commentaire avec commentaireID 1 pour l'item avec itemID 101 par le joueur avec joueureID 1.

-- Créer une quête
-- CALL CreateQuest(1, 'question', 'reponse1', 1, 'reponse2', 0, 'reponse3', 0, 'reponse4', 0);
-- Crée une nouvelle quête avec les réponses spécifiées. Dans cet exemple, la première réponse est correcte.

-- Supprimer une quête
-- CALL DeleteQuest(1);
-- Supprime la quête avec questID 1.

-- aperçu on moin d'info que details, details a tout genre apport calorique

-- Obtenir un aperçu d'un item dans le shop
-- CALL GetShopPreviewItem(101);
-- Récupère un aperçu de l'item avec itemID 101 dans le shop.

-- Obtenir les détails d'un item dans le shop
-- CALL GetShopItem(101);
-- Récupère les détails de l'item avec itemID 101 dans le shop.

-- Obtenir un aperçu d'un item dans l'inventaire
-- CALL GetInventoryPreviewItem(101);
-- Récupère un aperçu de l'item avec itemID 101 dans l'inventaire.

-- Obtenir les détails d'un item dans l'inventaire
-- CALL GetInventoryItemD(101);
-- Récupère les détails de l'item avec itemID 101 dans l'inventaire.

-- Obtenir les détails d'un item
-- CALL GetItemDetails(101);
-- Récupère les détails de l'item avec itemID 101.
