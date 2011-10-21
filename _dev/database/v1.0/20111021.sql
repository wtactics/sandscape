alter table Game
add lastChange int unsigned;

alter table Game
change state state longtext;
