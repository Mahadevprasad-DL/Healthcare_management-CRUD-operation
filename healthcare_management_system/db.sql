CREATE DATABASE healthcaremanagementsystem;

mysql> use healthcaremanagementsystem;
Database changed
 
 CREATE TABLE medications (
    MedicationID int(11) NOT NULL AUTO_INCREMENT,
    MedicationName varchar(100) DEFAULT NULL,
    Dosage varchar(50) DEFAULT NULL,
    Frequency varchar(50) DEFAULT NULL,
    PRIMARY KEY (MedicationID)
);

mysql> INSERT INTO medications (MedicationID, MedicationName, Dosage, Frequency) VALUES (14, 'Aspirin', '500mg', 'Once daily');
Query OK, 1 row affected (0.00 sec)

mysql> INSERT INTO medications (MedicationID, MedicationName, Dosage, Frequency) VALUES (21, 'Ibuprofen', '200mg', 'Every 6 hours');
Query OK, 1 row affected (0.00 sec)

mysql> INSERT INTO medications (MedicationID, MedicationName, Dosage, Frequency) VALUES (23, 'Lisinopril', '10mg', 'Twice daily');
Query OK, 1 row affected (0.01 sec)

mysql> INSERT INTO medications (MedicationID, MedicationName, Dosage, Frequency) VALUES (25, 'Metformin', '1000mg', 'Once daily with food');
Query OK, 1 row affected (0.01 sec)

mysql> INSERT INTO medications (MedicationID, MedicationName, Dosage, Frequency) VALUES (19, 'Levothyroxine', '50mcg', 'Every morning');
Query OK, 1 row affected (0.01 sec)

mysql> desc medications;
+----------------+--------------+------+-----+---------+----------------+
| Field          | Type         | Null | Key | Default | Extra          |
+----------------+--------------+------+-----+---------+----------------+
| MedicationID   | int(11)      | NO   | PRI | NULL    | auto_increment |
| MedicationName | varchar(100) | YES  |     | NULL    |                |
| Dosage         | varchar(50)  | YES  |     | NULL    |                |
| Frequency      | varchar(50)  | YES  |     | NULL    |                |
+----------------+--------------+------+-----+---------+----------------+
4 rows in set (0.01 sec)

mysql> select * from medications;
+--------------+----------------+--------+----------------------+
| MedicationID | MedicationName | Dosage | Frequency            |
+--------------+----------------+--------+----------------------+
|           14 | Aspirin        | 500mg  | Once daily           |
|           19 | Levothyroxine  | 50mcg  | Every morning        |
|           21 | Ibuprofen      | 200mg  | Every 6 hours        |
|           23 | Lisinopril     | 10mg   | Twice daily          |
|           25 | Metformin      | 1000mg | Once daily with food |
|           50 | Gabapentin     | 600mg  | Twice daily          |
|           89 | girish         | 10mg   |  twice daily         |
|           91 | mahadev        | 1mg    | as neeed             |
|           92 | mahadev        | 1mg    | as neeed             |
+--------------+----------------+--------+----------------------+
9 rows in set (0.00 sec)