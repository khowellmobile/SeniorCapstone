/*
*   FileName:   ScribeDB_CreateStoredProcedures.sql
*   Author:     Scribe Dev Team
*   Purpose:    To create the needed stored procedures for the Scribe Database
*/

------------------------------------ Errors Add ------------------------------------

/*
 *	Name:		spErrors_Add
 *	Purpose: 	Adds a line into the ScribeDb Errors table
 *  
 * 	@param		p_ClientName			VARCHAR(150)	Clients Name
 *	@param		p_ClientAddress			VARCHAR(150)	Clients Address
 *	@param		p_ClientEmail			VARCHAR(150)	Clients Email
*/
CREATE PROCEDURE spErrors_Add	
	(IN  p_Params		VARCHAR(150)
	,IN  p_ErrorNum		VARCHAR(50)
	,IN  p_ErrMessage	VARCHAR(100))

BEGIN
	-- Inserting into Errors Table
	INSERT INTO Errors(
		 ErrorDateTim
		,User		
		,ErrNum		
		,ErrMessage 
		,errParams	
		,isDeleted		
	)
	VALUES(
		 CURRENT_TIMESTAMP()
		,User()	
		,p_ErrNum	
		,p_ErrMessage 
		,p_Params
		,0);
END


------------------------------------ Clients Add/Update ------------------------------------


/*
 *	Name:		spClients_Add
 *	Purpose: 	Adds a line into the ScribeDb Clients table
 *  
 * 	@param		p_ClientName			VARCHAR(150)	Clients Name
 *	@param		p_ClientAddress			VARCHAR(150)	Clients Address
 *	@param		p_ClientEmail			VARCHAR(150)	Clients Email
 *	@param		p_Primary_PhoneNumber	VARCHAR(150)	Clients Primary Phone Number
 *	@param		p_Description			VARCHAR(200)	Description of client
 *	@param		p_Date_Aquired			DATE			Date client was aquired
 *	@param		p_Date_UnAquired		DATE			Date client was unaquuired
 *	@param		p_isDeleted				INT				If the client is deleted or not
*/
CREATE PROCEDURE spClients_Add	
	(IN  p_ClientName				VARCHAR(150)	
	,IN  p_ClientAddress			VARCHAR(150)
	,IN  p_ClientEmail				VARCHAR(150)
	,IN  p_Primary_PhoneNumber		VARCHAR(150)
	,IN  p_Description				VARCHAR(200)
	,IN  p_Date_Aquired				DATE		
	,IN  p_Date_UnAquired			DATE		
	,IN  p_isDeleted				INT)

BEGIN
	-- Inserting into Clients Table
	INSERT INTO Clients(
		 ClientName			
		,ClientAddress		
		,ClientEmail			
		,Primary_PhoneNumber	
		,Description			
		,Date_Aquired			
		,Date_UnAquired		
		,isDeleted		
	)
	VALUES(
		 p_ClientName			
		,p_ClientAddress			
		,p_ClientEmail			
		,p_Primary_PhoneNumber	
		,p_Description			
		,p_Date_Aquired			
		,p_Date_UnAquired		
		,p_isDeleted);			
END

/*
 *	Name:		spClients_Update
 *	Purpose: 	Upadtes a line in the ScribeDb Clients table
 *  
* 	@param		p_ClientID				INT				ClientsID in the table
 * 	@param		p_ClientName			VARCHAR(150)	Clients Name
 *	@param		p_ClientAddress			VARCHAR(150)	Clients Address
 *	@param		p_ClientEmail			VARCHAR(150)	Clients Email
 *	@param		p_Primary_PhoneNumber	VARCHAR(150)	Clients Primary Phone Number
 *	@param		p_Description			VARCHAR(200)	Description of client
 *	@param		p_Date_Aquired			DATE			Date client was aquired
 *	@param		p_Date_UnAquired		DATE			Date client was unaquuired
 *	@param		p_isDeleted				INT				If the client is deleted or not
*/
CREATE PROCEDURE spClients_Update
	(IN	 p_ClientID				INT				
		,p_ClientName			VARCHAR(150)
		,p_ClientAddress		VARCHAR(150)
		,p_ClientEmail			VARCHAR(150)
		,p_Contact_PhoneNumber	VARCHAR(150)
		,p_Description			VARCHAR(200)
		,p_Date_Aquired			DATE		
		,p_Date_UnAquired		DATE		
		,p_isDeleted			INT)

BEGIN

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_ClientID				, ' '
                    ,p_ClientName			, ' '
                    ,p_ClientAddress		, ' '
                    ,p_ClientEmail			, ' '
                    ,p_Contact_PhoneNumber	, ' '
                    ,p_Description			, ' '
                    ,p_Date_Aquired			, ' '
                    ,p_Date_UnAquired		, ' '
                    ,p_isDeleted);		
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;

	IF(!EXISTS(SELECT * FROM Clients WHERE ClientID = p_ClientID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_ClientName			= IFNULL(p_ClientName			, ClientName)	
			,p_ClientAddress		= IFNULL(p_ClientAddress		, ClientAddress)
			,p_ClientEmail			= IFNULL(p_ClientEmail			, ClientEmail)	
			,p_Contact_PhoneNumber	= IFNULL(p_Contact_PhoneNumber	, Contact_PhoneNumber)
			,p_Description			= IFNULL(p_Description			, Description)	
			,p_Date_Aquired			= IFNULL(p_Date_Aquired			, Date_Aquired)	
			,p_Date_UnAquired		= IFNULL(p_Date_UnAquired		, Date_UnAquired)
			,p_isDeleted			= IFNULL(p_isDeleted			, isDeleted)	
		FROM Clients
		WHERE ClientID = p_ClientID;


		UPDATE Clients SET	 				
			 ClientName				=	p_ClientName			
			,ClientAddress			=	p_ClientAddress				
			,ClientEmail			=	p_ClientEmail			
			,Contact_PhoneNumber	=	p_Contact_PhoneNumber	
			,Description			=	p_Description			
			,Date_Aquired			=	p_Date_Aquired				
			,Date_UnAquired			=	p_Date_UnAquired		
			,isDeleted				=	p_isDeleted					
		WHERE ClientID = p_ClientID;
	END IF;
END

------------------------------------ BankAccounts Add/Update ------------------------------------

/*
 *	Name:		spBankAccounts_Add
 *	Purpose: 	Adds a line in the ScribeDb BankAccounts table
 *  
 * 	@param		p_ClientID				INT				ClientID that the bank account is linked to
 * 	@param		p_BankID				INT				ID of the bank that the bank account belongs to
 *	@param		p_AccountType			VARCHAR(100)	Type of Bank Account
 *	@param		p_AccountNumber			INT				Number of the Bank Account
 *  @param		p_lastReconBalance		DECIMAL(15, 2)	Balance at the end of last reconciliation
 *  @param		p_lastReconDate			DATE			Date of last reconciliation
 *	@param		p_isDeleted				INT				If the BankAccount is deleted or not
*/
CREATE PROCEDURE spBankAccounts_Add
	(IN	 p_ClientID			INT			
	,IN p_BankID			INT			
	,IN p_AccountType		VARCHAR(100)
	,IN p_AccountNumber		INT		
	,IN p_lastReconBalance	DECIMAL(15, 2)
	,IN p_lastReconDate		DATE	
	,IN p_isDeleted			INT)			

BEGIN

	INSERT INTO BankAccounts(
		 ClientID		
		,BankID		
		,AccountType	
		,AccountNumber
		,lastReconBalance	
		,lastReconDate		
		,isDeleted)
	VALUES(
		 p_ClientID		
		,p_BankID		
		,p_AccountType	
		,p_AccountNumber
		,p_lastReconBalance	
		,p_lastReconDate			
		,p_isDeleted);

END

/*
 *	Name:		spBankAccounts_Update
 *	Purpose: 	Updates a line in the ScribeDb BankAccounts table
 *  
 *	@param		p_BankAccountID			INT				Bank Acccounts ID in the BankAccounts Table
 * 	@param		p_ClientID				INT				ClientID that the bank account is linked to
 * 	@param		p_BankID				INT				ID of the bank that the bank account belongs to
 *	@param		p_AccountType			VARCHAR(100)	Type of Bank Account
 *	@param		p_AccountNumber			INT				Number of the Bank Account
 *  @param		p_lastReconBalance		DECIMAL(15, 2)	Balance at the end of last reconciliation
 *  @param		p_lastReconDate			DATE			Date of last reconciliation
 *	@param		p_isDeleted				INT				If the Bank Account is deleted or not
*/
CREATE PROCEDURE spBankAccounts_Update
	(IN	 p_BankAccountID	INT			
		,p_ClientID			INT			
		,p_BankID			INT			
		,p_AccountType		VARCHAR(100)
		,p_AccountNumber	INT			
		,p_lastReconBalance	DECIMAL(15, 2)
		,p_lastReconDate	DATE	
		,p_isDeleted		INT)		
BEGIN	

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_BankAccountID	, ' '
                    ,p_ClientID			, ' '
                    ,p_BankID			, ' '
                    ,p_AccountType		, ' '
                    ,p_AccountNumber	, ' '
                    ,p_isDeleted);	
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;

	IF(!EXISTS(SELECT * FROM BankAccounts WHERE BankAccountID = p_BankAccountID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_ClientID			= IFNULL(p_ClientID			, ClientID)	
			,p_BankID			= IFNULL(p_BankID			, BankID)		
			,p_AccountType		= IFNULL(p_AccountType		, AccountType)	
			,p_AccountNumber	= IFNULL(p_AccountNumber	, AccountNumber)
			,p_lastReconBalance	= IFNULL(p_lastReconBalance	, lastReconBalance)	
			,p_lastReconDate	= IFNULL(p_lastReconDate	, lastReconDate)
			,p_isDeleted		= IFNULL(p_isDeleted		, isDeleted)	
		FROM BankAccounts
		WHERE BankAccountID = p_BankAccountID;

		UPDATE BankAccounts SET
			 ClientID		 	=	p_ClientID		
			,BankID			 	=	p_BankID		
			,AccountType	 	=	p_AccountType	
			,AccountNumber	 	=	p_AccountNumber	
			,lastReconBalance	= 	p_lastReconBalance	
			,lastReconDate		= 	p_lastReconDate	
			,isDeleted		 	=	p_isDeleted	
		WHERE BankAccountID = p_BankAccountID;
	END IF;
END


------------------------------------ Banks Add/Update ------------------------------------

/*
 *	Name:		spBanks_Add
 *	Purpose: 	Adds a line in the ScribeDb Banks table
 *  
 *	@param		p_BankName				VARCHAR(100)	Name of the Bank
 * 	@param		p_Bank_PhoneNumber		VARCHAR(100)	Phone Number for the Bank
 *	@param		p_isDeleted				INT				If the Bank is deleted or not
*/
CREATE PROCEDURE spBanks_Add
	(IN p_BankName				VARCHAR(100)
	,IN p_Bank_PhoneNumber		VARCHAR(100)
	,IN p_isDeleted				INT)				

BEGIN

	INSERT INTO Banks(
		 BankName			
		,Bank_PhoneNumber
		,isDeleted)		
	VALUES(
		 p_BankName			
		,p_Bank_PhoneNumber		
		,p_isDeleted);		
END

/*
 *	Name:		spBanks_Update
 *	Purpose: 	Upadtes a line in the ScribeDb Banks table
 *  
 *	@param		p_BankID				INT				Banks BankID in the Banks table
 *	@param		p_BankName				VARCHAR(100)	Name of the Bank
 * 	@param		p_Bank_PhoneNumber		VARCHAR(100)	Phone Number for the Bank
 *	@param		p_isDeleted				INT				If the Bank is deleted or not
*/
CREATE PROCEDURE spBanks_Update
	(IN	 p_BankID				INT			
		,p_BankName				VARCHAR(100)
		,p_Bank_PhoneNumber		VARCHAR(100)
		,p_isDeleted			INT)		

BEGIN

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_BankID		, ' '
                    ,p_BankName			, ' '
                    ,p_Bank_PhoneNumber	, ' '
                    ,p_isDeleted);	
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;	

	IF(!EXISTS(SELECT * FROM Banks WHERE BankID = p_BankID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT						
			 p_BankName				= IFNULL(p_BankName				,BankName)				
			,p_Bank_PhoneNumber		= IFNULL(p_Bank_PhoneNumber		,Bank_PhoneNumber)	
			,p_isDeleted			= IFNULL(p_isDeleted			,isDeleted)				
		FROM Banks
		WHERE BankID = p_BankID;

		UPDATE Banks SET		
			 BankName			 =	p_BankName			
			,Bank_PhoneNumber	 =	p_Bank_PhoneNumber	
			,isDeleted			 =	p_isDeleted
		WHERE BankID = p_BankID;
	END IF;
END


------------------------------------ Users Add/Update ------------------------------------

/*
 *	Name:		spUsers_Add
 *	Purpose: 	Adds a line in the ScribeDb Users table
 *  
 * 	@param		p_Username				VARCHAR(100)		Users username
 *	@param		p_Password				VARCHAR(100)		Users password
 *	@param		p_FirstName				VARCHAR(50)			Users first name
 *	@param		p_LastName				VARCHAR(50)			Users last name
 *	@param		p_userType				VARCHAR(150)		Type of user
 *	@param		p_HAEmployeeID			INT					Users EmployeeID
 *	@param		p_isDeleted				INT					If the user is deleted or not
 */
CREATE PROCEDURE spUsers_Add
	(IN	p_Username		VARCHAR(100)	
	,IN p_Password		VARCHAR(100)	
	,IN p_FirstName		VARCHAR(50)		
	,IN p_LastName		VARCHAR(50)		
	,IN p_userType		VARCHAR(150)
	,IN p_HAEmployeeID	INT				
	,IN p_isDeleted		INT)

BEGIN

	INSERT INTO Users(
		 Username		
		,Password		
		,FirstName	
		,LastName		
		,userType		
		,HAEmployeeID	
		,isDeleted)	
	VALUES(
		 p_Username		
		,p_Password		
		,p_FirstName		
		,p_LastName		
		,p_userType		
		,p_HAEmployeeID	
		,p_isDeleted);	
END

/*
 *	Name:		spUsers_Update
 *	Purpose: 	Updates a line in the ScribeDb Users table
 *  
 * 	@param		p_UserID				INT					Users UserID in the table
 * 	@param		p_Username				VARCHAR(100)		Users username
 *	@param		p_Password				VARCHAR(100)		Users password
 *	@param		p_FirstName				VARCHAR(50)			Users first name
 *	@param		p_LastName				VARCHAR(50)			Users last name
 *	@param		p_userType				VARCHAR(150)		Type of user
 *	@param		p_HAEmployeeID			INT					Users EmployeeID
 *	@param		p_isDeleted				INT					If the user is deleted or not
*/
CREATE PROCEDURE spUsers_Update
	(IN	 p_UserID		INT		
		,p_Username		VARCHAR(100)
		,p_Password		VARCHAR(100)
		,p_FirstName	VARCHAR(50)	
		,p_LastName		VARCHAR(50)	
		,p_userType		VARCHAR(150)
		,p_HAEmployeeID	INT			
		,p_isDeleted	INT)	

BEGIN			

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_UserID		, ' '
                    ,p_Username		, ' '
                    ,p_Password		, ' '
                    ,p_FirstName	, ' '
                    ,p_LastName		, ' '
                    ,p_userType		, ' '
                    ,p_HAEmployeeID	, ' '
                    ,p_isDeleted);	
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;

	IF(!EXISTS(SELECT * FROM Users WHERE UserID = p_UserID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT			
			 p_Username		= IFNULL(p_Username		, Username)		
			,p_Password		= IFNULL(p_Password		, Password)		
			,p_FirstName	= IFNULL(p_FirstName	, FirstName)		
			,p_LastName		= IFNULL(p_LastName		, LastName)		
			,p_userType		= IFNULL(p_userType		, userType)		
			,p_HAEmployeeID	= IFNULL(p_HAEmployeeID	, HAEmployeeID)	
			,p_isDeleted	= IFNULL(p_isDeleted	, isDeleted)
		FROM Users
		WHERE UserID = p_UserID;

		UPDATE Users SET	 				
			 Username		=	p_Username				
			,Password		=	p_Password			
			,FirstName		=	p_FirstName			
			,LastName		=	p_LastName			
			,userType		=	p_userType				
			,HAEmployeeID	=	p_HAEmployeeID	
			,isDeleted		=	p_isDeleted				
		WHERE UserID = p_UserID;
	END IF;
END


------------------------------------ HAEmployees Add/Update ------------------------------------

/*
 *	Name:		spHAEmployees_Add
 *	Purpose: 	Adds a line in the ScribeDb HAEmployees table
 *  
 *	@param		p_Employee_FirstName	VARCHAR(50)			Employees first name
 *	@param		p_Employee_LastName		VARCHAR(50)			Employees last name
 *	@param		p_PositionID			INT					Employees positionID
 *	@param		p_Employee_Email		VARCHAR(100)		Employees email
 *	@param		p_Employee_PhoneNumber	VARCHAR(100)		Employees phone number
 *	@param		p_isDeleted				INT					If the HaEmployee is deleted or not
 */
CREATE PROCEDURE spHAEmployees_Add
	(IN p_Employee_FirstName		VARCHAR(50)		
	,IN p_Employee_LastName			VARCHAR(50)		
	,IN p_PositionID				INT				
	,IN p_Employee_Email			VARCHAR(100)	
	,IN p_Employee_PhoneNumber		VARCHAR(100)	
	,IN p_isDeleted					INT)			

BEGIN 

	INSERT INTO HAEmployees(
		 Employee_FirstName
		,Employee_LastName	
		,PositionID		
		,Employee_Email	
		,Employee_PhoneNumber
		,isDeleted)
	VALUES(
		 p_Employee_FirstName
		,p_Employee_LastName	
		,p_PositionID		
		,p_Employee_Email	
		,p_Employee_PhoneNumber
		,p_isDeleted);		
END


/*
 *	Name:		spHAEmployees_Update
 *	Purpose: 	Updates a line in the ScribeDb HAEmployees table
 *  
 * 	@param		p_HAEmployeeID			INT					Employees HAEmployeeID in the HaEmployees table
 *	@param		p_Employee_FirstName	VARCHAR(50)			Employees first name
 *	@param		p_Employee_LastName		VARCHAR(50)			Employees last name
 *	@param		p_PositionID			INT					Employees positionID
 *	@param		p_Employee_Email		VARCHAR(100)		Employees email
 *	@param		p_Employee_PhoneNumber	VARCHAR(100)		Employees phone number
 *	@param		p_isDeleted				INT					If the HaEmployee is deleted or not
 */
CREATE PROCEDURE spHAEmployees_Update
	(IN	 p_HAEmployeeID				INT	
		,p_Employee_FirstName		VARCHAR(50)	
		,p_Employee_LastName		VARCHAR(50)	
		,p_PositionID				INT			
		,p_Employee_Email			VARCHAR(100)
		,p_Employee_PhoneNumber		VARCHAR(100)
		,p_isDeleted				INT)	

BEGIN	

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_HAEmployeeID			, ' '
                    ,p_Employee_FirstName	, ' '
                    ,p_Employee_LastName	, ' '
                    ,p_PositionID			, ' '
                    ,p_Employee_Email		, ' '
                    ,p_Employee_PhoneNumber	, ' '
                    ,p_isDeleted);
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;	

	IF(!EXISTS(SELECT * FROM HAEmployees WHERE HAEmployeeID = p_HAEmployeeID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_HAEmployeeID			= IFNULL(p_HAEmployeeID			, HAEmployeeID)			
			,p_Employee_FirstName	= IFNULL(p_Employee_FirstName	, Employee_FirstName)	
			,p_Employee_LastName	= IFNULL(p_Employee_LastName	, Employee_LastName)		
			,p_PositionID			= IFNULL(p_PositionID			, PositionID)			
			,p_Employee_Email		= IFNULL(p_Employee_Email		, Employee_Email)		
			,p_Employee_PhoneNumber	= IFNULL(p_Employee_PhoneNumber	, Employee_PhoneNumber)	
			,p_isDeleted			= IFNULL(p_isDeleted			, isDeleted)				
		FROM HAEmployees
		WHERE HAEmployeeID = p_HAEmployeeID;

		UPDATE HAEmployees SET	
			 Employee_FirstName		= p_Employee_FirstName	
			,Employee_LastName		= p_Employee_LastName		
			,PositionID				= p_PositionID			
			,Employee_Email			= p_Employee_Email		
			,Employee_PhoneNumber	= p_Employee_PhoneNumber	
			,isDeleted				= p_isDeleted
		WHERE HAEmployeeID = p_HAEmployeeID;
	END IF;
END


------------------------------------ Positions Add/Update ------------------------------------

/*
 *	Name:		spPositions_Add
 *	Purpose: 	Adds a line in the ScribeDb Positions table
 *  
 *	@param		p_Description	VARCHAR(150)			Description of the Position
 * 	@param		p_BaseRate		INT						Positions base pay rate
 *	@param		p_isDeleted		INT						If the position is deleted or not
*/
CREATE PROCEDURE spPositions_Add
	(IN	p_Description	VARCHAR(150)
	,IN p_BaseRate		INT		
	,IN p_isDeleted		INT)	

BEGIN

	INSERT INTO Positions(
		 Description
		,BaseRate	
		,isDeleted)
	VALUES(	
		 p_Description
		,p_BaseRate		
		,p_isDeleted);
END

/*
 *	Name:		spPositions_Update
 *	Purpose: 	Upadtes a line in the ScribeDb Positions table
 *  
 *	@param		p_PositionID	INT						Positions PositionID in the Positions table
 *	@param		p_Decription	VARCHAR(150)			Description of the Position
 * 	@param		p_BaseRate		INT						Positions base pay rate
 *	@param		p_isDeleted		INT						If the position is deleted or not
*/
CREATE PROCEDURE spPositions_Update
	(IN	 p_PositionID	INT			
		,p_Description	VARCHAR(150)
		,p_BaseRate		INT			
		,p_isDeleted	INT)			
BEGIN 

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT(p_PositionID, 			' '
					,p_Description,			' '
					,p_BaseRate, 			' '
					,p_isDeleted);
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;

	IF(!EXISTS(SELECT * FROM Positions WHERE PositionID = p_PositionID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_PositionID	= IFNULL(p_PositionID	,PositionID)
			,p_Description	= IFNULL(p_Description	,Description)
			,p_BaseRate		= IFNULL(p_BaseRate		,BaseRate)
			,p_isDeleted	= IFNULL(p_isDeleted	,isDeleted)
		FROM Positions
		WHERE PositionID = p_PositionID;


		UPDATE Positions SET
			 Description		 =	p_Description	
			,BaseRate		 =	p_BaseRate		
			,isDeleted		 =	p_isDeleted
		WHERE PositionID = p_PositionID;
	END IF;
END


------------------------------------ AssignedEmployees Add/Update ------------------------------------
/*
 *	Name:		spAssignedEmployees_Add
 *	Purpose: 	Adds a line in the ScribeDb AssignedEmployees table
 *  
 * 	@param		p_HAEmployeeID			INT				EmployeeID of the Assigned Employee
 *	@param		p_ClientID				INT				ClientID that the employee is assigned to
 *	@param		p_PreviousAssignment	INT				Previous employee the client was assigned to
 *	@param		p_isDeleted				INT				If the Assigned Employee is deleted or not
*/
CREATE PROCEDURE spAssignedEmployees_Add
	(IN	 p_HAEmployeeID				INT				
		,p_ClientID					INT				
		,p_PreviousAssignment		INT
		,p_DateAssigned				DATE)

BEGIN	

	INSERT INTO AssignedEmployees(
		 HAEmployeeID		
		,ClientID			
		,PreviousAssignment
		,DateAssigned)
	VALUES (
			 p_HAEmployeeID		
			,p_ClientID			
			,p_PreviousAssignment
			,p_DateAssigned);
END

/*
 *	Name:		spAssignedEmployees_Update
 *	Purpose: 	Updates a line in the ScribeDb AssignedEmployees table
 *  
 * 	@param		p_AssignedEmployeeID	INT				AssignedEmployeeID in the AssignedEmployees table
 * 	@param		p_HAEmployeeID			INT				EmployeeID of the Assigned Employee
 *	@param		p_ClientID				INT				ClientID that the employee is assigned to
 *	@param		p_PreviousAssignment	INT				Previous employee the client was assigned to
 *	@param		p_isDeleted				INT				If the Assigned Employee is deleted or not
*/
CREATE PROCEDURE spAssignedEmployees_Update
	(IN	 p_AssignedEmployeeID		INT
		,p_HAEmployeeID				INT
		,p_ClientID					INT
		,p_PreviousAssignment		INT
		,p_DateAssigned				DATE
		,p_isDeleted				INT)

BEGIN

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_AssignedEmployeeID	, ' '
                    ,p_HAEmployeeID			, ' '
                    ,p_ClientID				, ' '
                    ,p_PreviousAssignment	, ' '
                    ,p_DateAssigned			, ' '
                    ,p_isDeleted);	
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;	

	IF(!EXISTS(SELECT * FROM AssignedEmployees WHERE AssignedEmployeeID = p_AssignedEmployeeID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_AssignedEmployeeID	= IFNULL(p_AssignedEmployeeID	, AssignedEmployeeID)
			,p_HAEmployeeID			= IFNULL(p_HAEmployeeID			, HAEmployeeID)		
			,p_ClientID				= IFNULL(p_ClientID				, ClientID)		
			,p_PreviousAssignment	= IFNULL(p_PreviousAssignment	, PreviousAssignment)
			,p_DateAssigned			= IFNULL(p_DateAssigned			, DateAssigned)
			,p_isDeleted			= IFNULL(p_isDeleted			, isDeleted)
		FROM AssignedEmployees
		WHERE AssignedEmployeeID = p_AssignedEmployeeID;

		UPDATE AssignedEmployees SET
			 HAEmployeeID		 =	p_HAEmployeeID		
			,ClientID			 =	p_ClientID			
			,PreviousAssignment  =	p_PreviousAssignment
			,DateAssigned		 =	p_DateAssigned
			,isDeleted		 	 =  p_isDeleted
		WHERE AssignedEmployeeID = p_AssignedEmployeeID;
	END IF;
END


------------------------------------ Transactions Add/Update ------------------------------------

/*
 *	Name:		spTransactions_Add
 *	Purpose: 	Adds a line into the ScribeDb Transactions table
 *  
 *	@param		p_BankAccountID			INT					BankAccountID that this transaction belongs to
 *	@param		p_Date_Made				DATE				Date client made the transaction
 *	@param		p_Date_Processed		DATE				Date transaction was processed by the bank
 *	@param		p_Amount				DECIMAL(10, 2)				Amount of transaction
 *	@param		p_Description			VARCHAR(200)		Description of transaction
*  @param		p_TransNum				VARCHAR(10)			Check # for checks. ACH for Electronic transactions
 *	@param		p_TransactionTypeID		INT					Type of transaction
 *	@param		p_AccountTypeID			INT					Type of account the transaction belongs to
*  @param		p_isReconciled			INT					If the transaction has been reconciled or not
 *	@param		p_isDeleted				INT					If the transaction is deleted or not
*/
CREATE PROCEDURE spTransactions_Add(
    IN pBankAccountID 		INT,
    IN pDate_Made 			DATE,
    IN pDate_Processed 		DATE,
    IN pAmount 				DECIMAL(10, 2),
    IN pDescription 		VARCHAR(200),
	IN pTransNum			VARCHAR(10),
    IN pTransactionTypeID 	INT,
	IN pAccountTypeID		INT,
	IN pisReconciled		INT,	
    IN pisDeleted 			INT
)
BEGIN

    INSERT INTO Transactions(
        BankAccountID,
        Date_Made,
        Date_Processed,
        Amount,
        Description,
		TransNum,
        TransactionTypeID,
		AccountTypeID,
		isReconciled,
        isDeleted
    )
	VALUES(
    	pBankAccountID,
    	pDate_Made,
    	pDate_Processed,
    	pAmount,
    	pDescription,
		pTransNum,
    	pTransactionTypeID,
		pAccountTypeID,
		pisReconciled,
    	pisDeleted
	) ;
END

/*
 *	Name:		spTransactions_Update
 *	Purpose: 	Updates a line into the ScribeDb Transactions table
 *  
 * 	@param		p_TransactionID			INT					TransactionID of the Transaction in the Transactions table
 *	@param		p_BankAccountID			INT					BankAccountID that this transaction belongs to
 *	@param		p_Date_Made				DATE				Date client made the transaction
 *	@param		p_Date_Processed		DATE				Date transaction was processed by the bank
 *	@param		p_Amount				DECIMAL(10, 2)				Amount of transaction
 *	@param		p_Description			VARCHAR(200)		Description of transaction
 *  @param		p_TransNum				VARCHAR(10)			Check # for checks. ACH for Electronic transactions
 *	@param		p_TransactionTypeID		INT					Type of transaction
 *	@param		p_AccountTypeID			INT					Type of account the transaction belongs to
 *  @param		p_isReconciled			INT					If the transaction has been reconciled or not
 *	@param		p_isDeleted				INT					If the transaction is deleted or not
*/
CREATE PROCEDURE spTransactions_Update
	(IN	 p_TransactionID		INT				
		,p_BankAccountID		INT			
		,p_Date_Made			DATE
		,p_Date_Processed		DATE
		,p_Amount				DECIMAL(10, 2)		
		,p_Description			VARCHAR(200)
		,p_TransNum				VARCHAR(10)
		,p_TransactionTypeID	INT
		,p_AccountTypeID		INT	
		,p_isReconciled			INT
		,p_isDeleted			INT)		
				
BEGIN	

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_TransactionID		, ' '
                    ,p_BankAccountID		, ' '
                    ,p_Date_Made			, ' '
                    ,p_Date_Processed		, ' '
                    ,p_Amount				, ' '
                    ,p_Description			, ' '
					,p_TransNum	            , ' '
                    ,p_TransactionTypeID	, ' '
					,p_AccountTypeID		, ' '
					,p_isReconciled			, ' '
                    ,p_isDeleted);	
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;

	IF(!EXISTS(SELECT * FROM Transactions WHERE TransactionID = p_TransactionID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_TransactionID		= IFNULL(p_TransactionID		, TransactionID)		
			,p_BankAccountID		= IFNULL(p_BankAccountID		, BankAccountID)		
			,p_Date_Made			= IFNULL(p_Date_Made			, Date_Made)			
			,p_Date_Processed		= IFNULL(p_Date_Processed		, Date_Processed)		
			,p_Amount				= IFNULL(p_Amount				, Amount)			
			,p_Description			= IFNULL(p_Description			, Description)	
			,p_TransNum				= IFNULL(p_TransNum				, TransNum)		
			,p_TransactionTypeID	= IFNULL(p_TransactionTypeID	, TransactionTypeID)	
			,p_AccountTypeID		= IFNULL(p_AccountTypeID		, AccountTypeID)
			,p_isReconciled			= IFNULL(p_isReconciled			, isReconciled)		
			,p_isDeleted			= IFNULL(p_isDeleted			, isDeleted)			
		FROM Transactions
		WHERE TransactionID = p_TransactionID;

		UPDATE Transactions SET	 					
			 BankAccountID		=	p_BankAccountID				
			,Date_Made			=	p_Date_Made				
			,Date_Processed		=	p_Date_Processed			
			,Amount				=	p_Amount					
			,Description		=	p_Description	
			,TransNum			=	p_TransNum			
			,TransactionTypeID	=	p_TransactionTypeID	
			,AccountTypeID		=   p_AccountTypeID
			,isReconciled 		=	p_isReconciled
			,isDeleted			=	p_isDeleted					
		WHERE TransactionID = p_TransactionID;
	END IF;

END


------------------------------------ TransactionTypes Add/Update ------------------------------------

/*
 *	Name:		spTransactionTypes_Add
 *	Purpose: 	Adds a line in the ScribeDb TransactionTypes table
 *  
 *	@param		p_Description			VARCHAR(200)		Description of the transaction type
 *	@param		p_isCredit				INT					If this type of transaction is a credit or not
 *	@param		p_isDeleted				INT					If the transaction type is deleted or not
*/
CREATE PROCEDURE spTransactionTypes_Add	
	(IN	p_Description		VARCHAR(200)
	,IN p_isCredit			INT			
	,IN p_isDeleted			INT)		

BEGIN

	INSERT INTO TransactionTypes(
		 Description
		,isCredit	
		,isDeleted)
	VALUES (		
		 p_Description
		,p_isCredit		
		,p_isDeleted);	
END


/*
 *	Name:		spTransactionTypes_Update
 *	Purpose: 	Updates a line in the ScribeDb TransactionTypes table
 *  
 * 	@param		p_TransactionTypeID		INT					TransactionTypeID of the Transaction type in the TransactionTypes table
 *	@param		p_Description			VARCHAR(200)		Description of the transaction type
 *	@param		p_isCredit				INT					If this type of transaction is a credit or not
 *	@param		p_isDeleted				INT					If the transaction type is deleted or not
*/
CREATE PROCEDURE spTransactionTypes_Update
	(IN	 p_TransactionTypeID	INT			
		,p_Description			VARCHAR(200)
		,p_isCredit				INT			
		,p_isDeleted			INT)		

BEGIN

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_TransactionTypeID	, ' '
                    ,p_Description			, ' '
                    ,p_isCredit				, ' '
                    ,p_isDeleted);		
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;

	IF(!EXISTS(SELECT * FROM TransactionTypes WHERE TransactionTypeID = p_TransactionTypeID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_TransactionTypeID	= IFNULL(p_TransactionTypeID	, TransactionTypeID)	
			,p_Description			= IFNULL(p_Description			, Description)		
			,p_isCredit				= IFNULL(p_isCredit				, isCredit)			
			,p_isDeleted			= IFNULL(p_isDeleted			, isDeleted)			
		FROM TransactionTypes
		WHERE TransactionTypeID = p_TransactionTypeID;

		UPDATE TransactionTypes SET	
			 Description			 =	p_Description			
			,isCredit				 =	p_isCredit				
			,isDeleted				 =	p_isDeleted			
		WHERE TransactionTypeID = p_TransactionTypeID;
	END IF;
END

------------------------------------ AccountTypes Add/Update ------------------------------------

/*
 *	Name:		spAccountTypes_Add
 *	Purpose: 	Adds a line in the ScribeDb AccountTypes table
 *  
 * 	@param		p_AccountTypeName	VARCHAR(100)		Name of the type of account
 *	@param		p_Description		VARCHAR(150)		Description of the account type
 *	@param		p_isMain			INT					If the account is a main account or not
 *	@param		p_isDeleted			INT					If the Account type is deleted or not
*/
CREATE PROCEDURE spAccountTypes_Add
	(IN	p_AccountTypeName		VARCHAR(100)
	,IN p_Description			VARCHAR(150)
	,IN p_isMain				INT			
	,IN p_isDeleted				INT)		

BEGIN 
	INSERT INTO AccountTypes(
		 AccountTypeName
		,Description	
		,isMain		
		,isDeleted)
	VALUES(
		 p_AccountTypeName	
		,p_Description		
		,p_isMain			
		,p_isDeleted);
END

/*
 *	Name:		spAccountTypes_Update
 *	Purpose: 	Updates a line in the ScribeDb AccountTypes table
 *  
 * 	@param		p_AccountTypeID		INT					AccountTypeID of the account type in the AccountTypesTable
 * 	@param		p_AccountTypeName	VARCHAR(100)		Name of the type of account
 *	@param		p_Description		VARCHAR(150)		Description of the account type
 *	@param		p_isMain			INT					If the account is a main account or not
 *	@param		p_isDeleted			INT					If the Account type is deleted or not
*/
CREATE PROCEDURE spAccountTypes_Update
	(IN	 p_AccountTypeID		INT				
		,p_AccountTypeName		VARCHAR(100)
		,p_Description			VARCHAR(150)
		,p_isMain				INT			
		,p_isDeleted			INT)		

BEGIN

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_AccountTypeID		, ' '
                    ,p_AccountTypeName		, ' '
                    ,p_Description			, ' '
                    ,p_isMain				, ' '
					,p_isDeleted);
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;

	IF(!EXISTS(SELECT * FROM AccountTypes WHERE AccountTypeID = p_AccountTypeID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_AccountTypeID		= IFNULL(p_AccountTypeID		, AccountTypeID)
			,p_AccountTypeName		= IFNULL(p_AccountTypeName		, AccountTypeName)
			,p_Description			= IFNULL(p_Description			, Description)	
			,p_isMain				= IFNULL(p_isMain				, isMain)		
			,p_isDeleted			= IFNULL(p_isDeleted			, isDeleted)	
		FROM AccountTypes
		WHERE AccountTypeID = p_AccountTypeID;

		UPDATE AccountTypes SET
			 AccountTypeName	 =	p_AccountTypeName	
			,Description		 =	p_Description		
			,isMain			 	=	p_isMain			
			,isDeleted		 	=	p_isDeleted			
		WHERE AccountTypeID = p_AccountTypeID;
	END IF;
END

------------------------------------ ClientAccounts Add/Update ------------------------------------

/*
 *	Name:		spClientAccounts_Add
 *	Purpose: 	Adds a line in the ScribeDb ClientAccounts table
 *  
 * 	@param		p_ClientID			INT					Client the account belongs to
 *	@param		p_AccountTypeID		INT					Type of account
 *	@param		p_Balance			DECIMAL(15,2)		Current account balance
 *	@param		p_isDeleted			BIT					If the account is deleted or not
*/
CREATE PROCEDURE spClientAccounts_Add
	(IN	p_ClientID			INT			
	,IN p_AccountTypeID		INT			
	,IN p_Balance			DECIMAL(15,2)
	,IN p_isDeleted			BIT)	

BEGIN 
	INSERT INTO ClientAccounts(
		 ClientID	
		,AccountTypeID
		,Balance	
		,isDeleted)
	VALUES(
		 p_ClientID		
		,p_AccountTypeID	
		,p_Balance		
		,p_isDeleted);
END

/*
 *	Name:		spClientAccounts_Update
 *	Purpose: 	Updates a line in the ScribeDb ClientAccounts table
 *  
 * 	@param		p_AccountTypeID		INT					AccountTypeID of the account type in the AccountTypesTable
 * 	@param		p_AccountTypeName	VARCHAR(100)		Name of the type of account
 *	@param		p_Description		VARCHAR(150)		Description of the account type
 *	@param		p_isMain			INT					If the account is a main account or not
 *	@param		p_isDeleted			INT					If the Account type is deleted or not
*/
CREATE PROCEDURE spClientAccounts_Update
	(IN	 p_ClientAccountID	INT			
		,p_ClientID			INT			
		,p_AccountTypeID	INT			
		,p_Balance			DECIMAL(15,2)
		,p_isDeleted		BIT)	

BEGIN

	DECLARE ID_Doesnt_Exist CONDITION FOR SQLSTATE '40001';

	DECLARE EXIT HANDLER FOR ID_Doesnt_Exist
    BEGIN
		SET @errMessage = "Input ID does not exist.";
		SET @errNum = '40001';
		SET @p = CONCAT( p_ClientAccountID		, ' '
                    ,p_ClientID				, ' '
                    ,p_AccountTypeID		, ' '
                    ,p_Balance				, ' '
					,p_isDeleted);	
		CALL spErrors_Add(@p, @errMessage, @errNum);
    END;	

	IF(!EXISTS(SELECT * FROM ClientAccounts WHERE ClientAccountID = p_ClientAccountID)) THEN
		SIGNAL ID_Doesnt_Exist;
	ELSE
		SELECT		
			 p_ClientAccountID		= IFNULL(p_ClientAccountID		, ClientAccountID)
			,p_ClientID				= IFNULL(p_ClientID				, ClientID)
			,p_AccountTypeID		= IFNULL(p_AccountTypeID		, AccountTypeID)
			,p_Balance				= IFNULL(p_Balance				, Balance)	
			,p_isDeleted			= IFNULL(p_isDeleted			, isDeleted)		
		FROM ClientAccounts
		WHERE ClientAccountID = p_ClientAccountID;

		UPDATE ClientAccounts SET
			 ClientID			=	p_ClientID			
			,AccountTypeID	 	=	p_AccountTypeID	
			,Balance			=	p_Balance			
			,isDeleted		 	=	p_isDeleted		
		WHERE ClientAccountID = p_ClientAccountID;
	END IF;
END
