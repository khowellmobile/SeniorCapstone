/*
*   FileName:   ScribeDB_TableCreation.sql
*   Author:     Scribe Dev Team
*   Purpose:    To create the tables necesarry for the Scribe Database
*/

CREATE TABLE Errors (
	ErrorID 		INT				NOT NULL	AUTO_INCREMENT,
	ErrorDateTime	TIMESTAMP		NOT NULL,
	User			VARCHAR(50)		NOT NULL,
	ErrNum			VARCHAR(50)		NOT NULL,
	ErrMessage 		VARCHAR(150)	NOT NULL,
	errParams		VARCHAR(150)	NOT NULL,
	isDeleted		BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (ErrorID)	
);

CREATE TABLE Clients (
	ClientID			INT				NOT NULL	AUTO_INCREMENT,
	ClientName			VARCHAR(100)	NOT NULL,
	ClientAddress		VARCHAR(150),
	ClientEmail			VARCHAR(100)	NOT NULL,
	Contact_PhoneNumber	VARCHAR(100)	NOT NULL,
	Description			VARCHAR(200),
	Date_Aquired		DATE,
	Date_UnAquired		DATE,
	isDeleted			BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (ClientID)
);

CREATE TABLE Positions (
	PositionID		INT				NOT NULL	AUTO_INCREMENT,
	Description		VARCHAR(150)	NOT NULL,
	BaseRate		INT				NOT NULL,
	isDeleted		BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (PositionID)
);

CREATE TABLE HAEmployees (
	HAEmployeeID			INT				NOT NULL	AUTO_INCREMENT,
	Employee_FirstName		VARCHAR(50)		NOT NULL,
	Employee_LastName		VARCHAR(50)		NOT NULL,
	PositionID				INT				NOT NULL,
	Employee_Email			VARCHAR(100)	NOT NULL,
	Employee_PhoneNumber	VARCHAR(100)	NOT NULL,
	isDeleted				BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (HAEmployeeID),
	FOREIGN KEY (PositionID) REFERENCES Positions(PositionID)
);

CREATE TABLE Users (
	UserID			INT				NOT NULL	AUTO_INCREMENT,
	Username		VARCHAR(100)	NOT NULL,
	Password		VARCHAR(100)	NOT NULL,
	FirstName		VARCHAR(50)		NOT NULL,
	LastName		VARCHAR(50)		NOT NULL,
	userType		VARCHAR(150),
	HAEmployeeID	INT				NOT NULL,
	isDeleted		BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (UserID),
	FOREIGN KEY (HAEmployeeID)	REFERENCES HAEmployees(HAEmployeeID)
);

CREATE TABLE AssignedEmployees (
	AssignedEmployeeID		INT				NOT NULL	AUTO_INCREMENT,
	HAEmployeeID			INT				NOT NULL,
	ClientID				INT				NOT NULL,
	PreviousAssignment		INT,
	DateAssigned			DATE			NOT NULL,
	isDeleted				BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (AssignedEmployeeID),
	FOREIGN KEY (HAEmployeeID) REFERENCES HAEmployees(HAEmployeeID),
	FOREIGN KEY (ClientID) REFERENCES Clients(ClientID)
);

CREATE TABLE Banks (
	BankID				INT				NOT NULL	AUTO_INCREMENT,
	BankName			VARCHAR(100)	NOT NULL,
	Bank_PhoneNumber	VARCHAR(100),
	isDeleted			BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (BankID)
);

CREATE TABLE BankAccounts (
	BankAccountID		INT				NOT NULL	AUTO_INCREMENT,
	ClientID			INT				NOT NULL,
	BankID				INT				NOT NULL,
	AccountType			VARCHAR(100)	NOT NULL,
	AccountNumber		VARCHAR(50)		NOT NULL,
	lastReconBalance 	DECIMAL(15, 2) 	NOT NULL,
	lastReconDate		DATE			NOT NULL,
	isDeleted			BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (BankAccountID),
	FOREIGN KEY (ClientID) REFERENCES Clients(ClientID),
	FOREIGN KEY (BankID) REFERENCES Banks(BankID)
);

CREATE TABLE TransactionTypes (
	TransactionTypeID	INT				NOT NULL	AUTO_INCREMENT,
	Description			VARCHAR(200)	NOT NULL,
	isCredit			BIT				NOT NULL,
	isDeleted			BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (TransactionTypeID)
);

CREATE TABLE AccountTypes (
	AccountTypeID		INT				NOT NULL	AUTO_INCREMENT,
	AccountTypeName		VARCHAR(100)	NOT NULL,
	Description			VARCHAR(150)	NOT NULL,
	isMain				BIT				NOT NULL,
	isDeleted			BIT				NOT NULL 	DEFAULT 0,
	PRIMARY KEY (AccountTypeID)
);

CREATE TABLE Transactions (
	TransactionID		INT				NOT NULL	AUTO_INCREMENT,
	BankAccountID		INT				NOT NULL,
	Date_Made			DATE			NOT NULL,
	Date_Processed		DATE			NOT NULL,
	Amount				DECIMAL(10,2)	NOT NULL,
	Description			VARCHAR(200)	NOT NULL,
	TransNum			VARCHAR(10)		NOT NULL,
	TransactionTypeID	INT				NOT NULL,
	AccountTypeID		INT				NOT NULL,
	isReconciled		BIT				NOT NULL	DEFAULT	0,
	isDeleted			BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (TransactionID),
	FOREIGN KEY (BankAccountID) REFERENCES BankAccounts(BankAccountID),
	FOREIGN KEY (TransactionTypeID) REFERENCES TransactionTypes(TransactionTypeID),
	FOREIGN KEY (AccountTypeID) REFERENCES AccountTypes(AccountTypeID)
);

CREATE TABLE ClientAccounts (
	ClientAccountID		INT				NOT NULL	AUTO_INCREMENT,
	ClientID			INT				NOT NULL,
	AccountTypeID		INT				NOT NULL,
	Balance				DECIMAL(15,2)	NOT NULL	DEFAULT 0,
	isDeleted			BIT				NOT NULL	DEFAULT 0,
	PRIMARY KEY (ClientAccountID),
	FOREIGN KEY	(ClientID) REFERENCES Clients(ClientID),
	FOREIGN KEY	(AccountTypeID) REFERENCES AccountTypes(AccountTypeID)
);