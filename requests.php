CREATE TABLE xml_to_sql.person (
	name varchar(255) NULL,
	age INT NULL,
	email varchar(100) NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE xml_to_sql.book (
	title varchar(100) NULL,
	author varchar(100) NULL,
	`year` INT NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

