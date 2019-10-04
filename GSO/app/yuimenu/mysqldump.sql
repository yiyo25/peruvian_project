This an cample of build Yahoo UI menu from database
----- MySQL DUMP table structure and sample data---------cut here
USE test;<br>

# Table structure for table 'h_meny'<br>

CREATE TABLE IF NOT EXISTS h_menu (<br>
  id tinyint(3) NOT NULL auto_increment,<br>
  level int(2) ,<br>
  point varchar(30) ,<br>
  link varchar(30) ,<br>
  hint varchar(40) ,<br>
  sublevel varchar(30) ,<br>
  PRIMARY KEY (id)<br>
);<br>


# Dumping data for table 'h_meny'<br>

INSERT INTO h_meny VALUES("1","1","level one item 1","#","it's a hint","0");<br>
INSERT INTO h_meny VALUES("2","1","level one item 2","#","it's a hint","0");<br>
INSERT INTO h_meny VALUES("3","2","level 2 item 1","#","it's a hint","1");<br>
INSERT INTO h_meny VALUES("4","2","level 2 item 1","#","it's a hint","2");<br>
INSERT INTO h_meny VALUES("5","2","level 2 item 2","#","it's a hint","1");<br>
INSERT INTO h_meny VALUES("6","2","level 3 item 1","#","it's a hint","4");<br>

----- MySQL DUMP table structure and sample data---------end cut
