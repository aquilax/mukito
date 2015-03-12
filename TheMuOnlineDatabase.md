# Chapter 1.2 - The Mu Online database #

This database is constructed in an rather easy to edit way - also it easy quite easy to understand what is what around there. The basic tables that are required to run normally a mu server are: (AccountCharacter, Character, MEMB\_INFO, warehouse, Guild, GuildMember, VI\_CURR\_INFO) these 7 tables make the server playable and access able error-less by everyone, however if you are using new versions with their databases you should see tables like (MuCastle_, MuCrywolf\_DATA, T_). Also a table that is not critical but is recommendable to keep user information stored is MEMB\_STAT.
What does each table do?

[AccountCharacter](AccountCharacter.md) -> Stores information about the characters in this account, their order and the last one used.

[Character](Character.md) -> Stores information about the characters in the server such as: Char name, Level, Experience, Current location, PK's, Stats, Items in inventory..etc.. you get the point

[MEMB\_INFO](MEMB_INFO.md) -> The account information..name,email,password and other personal data.
[warehouse](warehouse.md) -> The account personal storage space data. (Items, Cash)

[Guild](Guild.md) -> Guild data ( Name, Score, Master, Logo )

[GuildMember](GuildMember.md) -> Character's guild membership and their place in the guild (e.g. gm/battle master..)

[VI\_CURR\_INFO](VI_CURR_INFO.md) -> Used by the payed servers to manage who has his account active and who hasn't.

[MEMB\_STAT](MEMB_STAT.md) -> Stores some account info like (Last ip used, last time connected/disconnected, The last accessed server)

I will not comment the new version fields.

Items in the database:
The items (inventory,warehouse) in the muonline database are stored in a var binary valued field. Each item has length of 10bin symbols or 20varchar symbols.
An example item is
```
-----------------------------
4252FF22222222840000 (Pad gloves+10+8+Reflect)
42 -> Item category (e.g. boots/swords/staffs/gloves/etc..) and the item id
52 -> Item Level/Option/Luck/Skill
FF -> Item Durability
22222222 -> Item Serial Code (With every new item that drops in the server a mssql 
procedures is triggered, which increases the values of items dropped in the server 
by 1(one) and generated a hex value for the item serial. This is useful for preventing 
item duplications and to specific items.
84 -> Item Excellent option/ Second type (for some items) and value of an option>+16
0000 -> Ancient Item Data
-----------------------------
```

Editing/adding items "by hand" will be really annoying, thats why people have worked hard to make good editors for this purpose (search to find some).

The developers at webzen have though that it will be best if they make the game server and login server to execute procedures instead of full queries. You can edit them if you know what you are doing to create some fun and/or useful features.

Taken from http://forum.ragezone.com/f196/guide-the-mu-server-basics-252460/