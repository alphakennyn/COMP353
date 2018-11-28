#CheckingAccount
#SavingsAccount
#BusinessAccount
#LineOfCredit
#CreditCard
 
from math import*
import random


randarr=[1,2,3,4,5,6,7,8,9,10]       
sqlscript = open("populateTables.sql", "w", encoding = "utf-8")
names= open("names.txt", "r",encoding="utf-8")  
streets= open("streets.txt","r",encoding="utf-8")
cities= open("cities.txt", "r", encoding="utf-8")
categories = ['banker', 'investment', 'insurance']
surnames = open("surnames.txt","r",encoding="utf-8")
posarr=["Loan Officer", "Financial Analyst", "Bank Teller", "Investment Broker", "Insurance Broker", "Secretary", "Financial Planner", "Bank Examiner", "Credit Analyst", "Investment Planner"]
manageArr=["President","Investment Manager","Insurance Manager","Banking Manager"]
clientCategory=["Personal", "Business", "Corporate"]

ids = []
category = []
phone = []
startDate = []
hourlyWage = []
availableSick = []
availableHoliday = []
title = []
streetArr = []
addresses = []
fullNames = []
citiesArr= []


for i in range (0,28):
    citiesArr.append(cities.readline().rstrip())



#Employee
for i in range (1, 65):
    ids.append(i)
    category.append(str(categories[random.randrange(0,3)]))
    phone.append(5140000000 + random.randint(0,9999999))
    fullNames.append(str(names.readline().rstrip() + " " + surnames.readline().rstrip()))
    addresses.append(str(random.randrange(0,9999)) + " " + streets.readline().rstrip())
    hourlyWage.append(random.randrange(10,20))
    startDate.append(str(random.randrange(2000,2018))+"-"+ str(random.randrange(1,10))+"-"+str(random.randrange(1,28)))
    availableSick.append(random.randrange(0,3))
    availableHoliday.append(random.randrange(0,14))
    password = 'teamkey'
    if(i < 51):
        title.append(posarr[random.randrange(0,9)])
    elif(i < 61):
        title.append("Manager")
    else:
        title.append(manageArr[i-61])
    sqlscript.write("INSERT INTO Employee(category, phone, title, fullName, address, hourlyWage, startDate, availableSick, availableHoliday, pass) values ('%s',%i,'%s','%s','%s',%f, '%s', %i, %i, '%s');\n" %( category[i-1], phone[i-1], title[i-1], fullNames[i-1], addresses[i-1], hourlyWage[i-1], startDate[i-1], availableSick[i-1], availableHoliday[i-1], password))
      
#bank
bName = "ABCJK"
hqL = "1634 Rue Guy"
pres = 61
invMan = 62
insMan = 63
bankMan = 64
sqlscript.write("INSERT INTO Bank(bankName, hqLocation, president, investManager, insureManager, bankManager) values('%s','%s',%i,%i,%i,%i);\n" % (bName, hqL,pres,invMan,insMan,bankMan))



            
#branch
for i in range (1,11):
    bphone = 5140000000 + random.randint(0,9999999)
    bfax = 5140000000 + random.randint(0,9999999)
    city = str(citiesArr[random.randint(0,15)])
    location =str(streets.readline().rstrip())
    openingDate= str(random.randrange(1990,2010))+"-"+ str(random.randrange(1,10))+"-"+str(random.randrange(1,28))
    revenue =  random.randint(15000, 500000)
    sqlscript.write("INSERT INTO Branch(phone, fax, location, city, openingDate, revenue, managerId) values ( %i, %i,'%s','%s','%s',%f, %i );\n" %(bphone,bfax,location,city,openingDate, revenue, 50+i ))



#Services
sid = [1,2,3]
sType = ["Banking", "Investment", "Insurance"]

for i in range (0,3):
    sqlscript.write("INSERT INTO Services(id, serviceType) values (%i,'%s');\n" % (sid[i], str(sType[i])))


#Service Available
#banking = 1 
#investment = 2
#insurance = 3
#banking/invest = 4
#banking/insurance = 5
#banking/invest/insurance = 6
#assume that every branch at minimum does banking

for i in range (1, 11):
    check = random.randrange(1,6)
    if check == 1:
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 1))
    elif check == 2:
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 2))
    elif check == 3:
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 3))
    elif check == 4:
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 1))
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 2))
    elif check == 5:
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 1))
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 3))
    elif check == 6:
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 1))
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 2))
        sqlscript.write("INSERT INTO ServiceAvailable(bid,seId) values (%i, %i);\n" % (i, 3))


#Schedule
#YYYY-MM-DD HH:MI:SS
schedIds = []
sTimes = ['09:00:00', '10:00:00']
eTimes = ['17:00:00', '18:00:00']
startT = []
endT = []
holi = []
sick = []
cIn = ''
cOut = ''



for i in range (1,29):
    temp = random.randrange(0,1)
    startT.append('2018-11'+ '-' + str(i) + ' ' + sTimes[temp])
    endT.append('2018-11'+ '-' + str(i) + ' ' + eTimes[temp])


for i in range (1,65):
    for x in range (1,29):
        temp = random.randrange(1,2)
        check = random.randrange(1,100)
        if (x == 3) or (x == 4) or (x == 10) or (x == 11) or (x == 17) or (x == 18) or (x == 24) or (x == 25):
            pass
        else: 
            if check == 1:
                isHoliday = 1
                holi.append(check)
            else:
                isHoliday = 0
                holi.append(check)
        
            if check == 2:
                isSick = 1
                sick.append(check)
            else:
                isSick = 0
                sick.append(check)
            sqlscript.write("INSERT INTO Schedule(eid, startTime, endTime, isHoliday, isSickDay) values (%i, '%s','%s', %i, %i);\n" %(i, str(startT[x-1]), str(endT[x-1]), isHoliday, isSick))
            
            #payroll

            if isSick == 1 or isHoliday == 1:
                pass    
            else:
                if startT[x-1] == '2018-11'+ '-' + str(x) + ' ' + '09:00:00':
                    second = random.randrange(10,59)
                    minute = random.randrange(45,59)
                    cIn = '2018-11'+ '-' + str(x) + ' 08:' + str(minute) + ':' + str(second)
                elif startT[x-1] == '2018-11'+ '-' + str(x) + ' ' + '10:00:00':
                    second = random.randrange(10,59)
                    minute = random.randrange(45,59)
                    cIn = '2018-11'+ '-' + str(x) + ' 09:' + str(minute) + ':' + str(second)


                if endT[x-1] == '2018-11'+ '-' + str(x) + ' ' + '17:00:00':
                    second = random.randrange(10,59)
                    minute = random.randrange(10,15)
                    cOut =  '2018-11'+ '-' + str(x) + ' 17:' + str(minute) + ':' + str(second)
                elif endT[x-1] == '2018-11'+ '-' + str(x) + ' ' + '18:00:00':
                    second = random.randrange(10,59)
                    minute = random.randrange(10,15)
                    cOut =  '2018-11'+ '-' + str(x) + ' 18:' + str(minute) + ':' + str(second) 
                sqlscript.write("INSERT INTO Payroll(eid, clockIn, clockOut) values (%i,'%s','%s');\n" %(i, str(cIn), str(cOut)))

                


#WorksAt
#Regular Employees
for i in range (1,51):
    wBranch = random.randrange(1,11)
    sqlscript.write("INSERT INTO WorksAt(eid, bid) values (%i, %i);\n" %(i, wBranch))

#managers
for i in range (1,11):
    sqlscript.write("INSERT INTO WorksAt(eid, bid) values (%i, %i);\n" %((50 + i), i))



#Clients
for i in range(1, 31):
    first = names.readline().rstrip()
    last = surnames.readline().rstrip()
    cname = first + ' ' + last
    password =  "teamkey"
    email = (str(random.randint(0,270))+ first + "@gmail.com").lower()
    category = clientCategory[random.randrange(0,2)]
    phone = 5140000000 + random.randint(0,9999999)
    chome =streets.readline().rstrip()         
    datejoined = str(random.randrange(1990,2000))+"-"+ str(random.randrange(1,10))+"-"+str(random.randrange(1,28))
    dob = str(random.randrange(1945,2000))+"-"+ str(random.randrange(1,10))+"-"+str(random.randrange(1,28))
    sqlscript.write("INSERT INTO Clients(id, pass, fullName, category, phone, email, address, joinDate, DOB, cardNumber) values (%i,'%s','%s','%s', %i ,'%s','%s','%s','%s', %i);\n" %(i,password,cname,category,phone,email,chome, datejoined, dob, 5000+i ))






#member
for i in range (1,31):
    cBranch = random.randrange(1,11)
    sqlscript.write("INSERT INTO Member(cid,bid) values (%i,%i);\n" %(i, cBranch))


#charge plans Needed
#Checking
#Savings
#investment
#insurance
#foreign currency
#credit card
#busniess
#lineofcredit
#Loan

sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(1, 50, 'Checking', 15))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(2, 20, 'Savings', 10))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(3, 20, 'Investment', 30))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(4, 0, 'Insurance', 12))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(5, 20, 'Foreign Currency', 20))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(6, 1000000, 'Credit Card', 5))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(7, 1000000, 'Business', 18))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(8, 200, 'Line Of Credit', 8))
sqlscript.write("INSERT INTO ChargePlan(id, planLimit, planOption, charge) values (%i,%i,'%s', %s);\n" %(9, 5, 'Loan', 18))


#Interest rate Needed
#Checking
#Savings
#investment
#insurance
#foreign currency
#credit card
#busniess
#lineofcredit
#Loan

sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(1,"Banking","Checking",0.0))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(2,"Banking","Savings",0.02))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(3,"Investment","Investment",0.02))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(4,"Insurance","Insurance",0.0))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(5,"Banking","Foreign Currency",0.001))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(6,"Banking","Credit Card",0.2))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(7,"Banking","Business",0.15))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(8,"Banking","Line Of Credit",0.15))
sqlscript.write("INSERT INTO InterestRate(id, serviceType, typeOfAccount, percentCharge) values (%i,'%s', '%s', %f);\n" %(9,"Banking","Loan",0.05))


aTypes = ['Checking', 'Savings', 'Investment', 'Insurance', 'Foreign Currency', 'Credit Card', 'Business', 'Line of Credit', 'Loan']
fc = ['USD', 'EUR', 'AUD', 'GBP', 'YEN']

#Account
for i in range(1,61):
    cpid = random.randrange(1,9)
    tp= aTypes[cpid-1]    
    if(cpid==1):
        transactions = 200
        transactionsLeft = random.randrange(0,201)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(1000,9999)
        minBalance= 'NULL'
        businessNumber= 'NULL'                
        creditLimit= 'NULL'
        taxId= 'NULL'
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %s, %s, %s,%s);\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==2):
        transactions = 20
        transactionsLeft = random.randrange(0,21)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(1000,9999)
        minBalance= 200
        businessNumber= 'NULL'
        creditLimit=  'NULL'
        taxId= 'NULL'
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %i,%s,%s,%s);\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==3):
        transactions = 20
        transactionsLeft = random.randrange(0,21)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(1000,9999)
        minBalance= 200
        businessNumber= 'NULL'
        creditLimit=  'NULL'
        taxId= 'NULL'
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %i, %s, %s, %s);\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==4):
        transactions = 10
        transactionsLeft = random.randrange(0,11)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(1000,9999)
        minBalance= 'NULL'
        businessNumber= 'NULL'
        creditLimit= 'NULL'
        taxId= 'NULL'
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %s,%s,%s,%s);\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==5):
        transactions = 20
        transactionsLeft = random.randrange(0,21)
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(1000,9999)
        currency = fc[random.randint(0,4)]
        minBalance= 200
        businessNumber= 'NULL'
        creditLimit= 'NULL'
        taxId= 'NULL'
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %i, %s, %s, %s);\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==6):
        transactions = 1000000
        transactionsLeft = random.randrange(0,100000)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(1000,9999)
        minBalance= 'NULL'
        businessNumber= 'NULL'
        creditLimit= random.randint(8000,9000)
        taxId= 'NULL'
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %s,%s,%s,'%s');\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==7):
        transactions = 1000000
        transactionsLeft = random.randrange(0,100000)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(10000,99999)
        minBalance= 200
        businessNumber= random.randrange(1,55)
        creditLimit=  'NULL'
        taxId= random.randrange(1,55)
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %i,'%s', %i, %s);\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==8):
        transactions = 200
        transactionsLeft = random.randrange(0,201)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(8000,9000)
        minBalance=  'NULL'
        businessNumber= 'NULL'
        creditLimit=random.randint(500,10000)
        taxId= 'NULL'
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %s, %s, %s, '%s');\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))
    elif(cpid==9):
        transactions = 5
        transactionsLeft = random.randrange(0,6)
        currency = 'CAD'
        isNotified = random.randint(0,1)
        maxPerDay=random.randint(500,50000)
        balance = random.randrange(1000,9999)
        minBalance=  'NULL'
        businessNumber= 'NULL'
        creditLimit=  'NULL'
        taxId= 'NULL'        
        sqlscript.write("insert into Account(cpid, irid, balance, transactionsPerMonth, transactionsLeft, currency, isNotified, accountType, maxPerDay, minBalance,businessNumber, taxId, creditLimit) values (%i,%i,%i,%i,%i,'%s',%i,'%s',%i, %s, %s, %s, %s);\n" %(cpid,cpid, balance, transactions, transactionsLeft, currency, isNotified, tp, maxPerDay, minBalance,businessNumber, taxId, creditLimit))

    



#AssociatedTo
for i in range (1, 61):
    sqlscript.write("insert into AssociatedTo(bid, accountNumber) values (%i,%i);\n" %(random.randrange(1,11), i))


#AccountsOwned
for i in range (1, 31):
    sqlscript.write("INSERT INTO AccountsOwned(cid, accountNumber) values (%i,%i);\n" %(i, i))

for i in range (31,61):
    sqlscript.write("INSERT INTO AccountsOwned(cid, accountNumber) values (%i,%i);\n" %(i-30, i))




transactionType = ["Debit","Credit","Transfer", "Bill Payment","e-Transfer"]
#Transactions
month= 1
year = 2000
for i in range(1,305):
    if(i%2==0):
        day= random.randint(15,28)
    else:
        day= random.randint(1,15)

    bid = random.randrange(1,11)
    accountNumber = random.randrange(1,61)
    transType = transactionType[random.randint(0,4)]
    amount = random.randrange(50,300)
    tstamp = str(year)+"-"+str( month) +"-"+str(day)+ ' ' + str(random.randrange(1,12)).zfill(2) + ':' + str(random.randrange(0,59)).zfill(2) + ':' + str(random.randrange(0,59)).zfill(2)
    if(transType== "e-Transfer" ):
        recipientAccountNumber= random.randint(1,60)
        sqlscript.write("INSERT INTO Transactions(bid, accountNumber, transType, amount, tStamp, recipientAccountNumber) values (%i,%i,'%s',%f,'%s',%i);\n" %(bid, accountNumber, transType, amount, tstamp, recipientAccountNumber))
    else:
        recipientAccountNumber= 'NULL'
        sqlscript.write("INSERT INTO Transactions(bid, accountNumber, transType, amount, tStamp, recipientAccountNumber) values (%i,%i,'%s',%f,'%s',%s);\n" %(bid, accountNumber, transType, amount, tstamp, recipientAccountNumber))

    if(i%2==0):
        month=month+1

    if(i% 24==0):
        year=year+1
        month=1

#Payee
payeees = ['Bell', 'Fido', 'Videotron', 'Rogers', 'Virgin', 'Telus', 'Sprint', 'Verizon', 'AT&t', 'Spotify', 'Netflix', 'Github', 'AWS', 'Azure', 'Sasktel']
for i in range (1, 15):
    sqlscript.write("INSERT INTO Payee(payeeName) values ('%s');\n" %(payeees[i]))

#MyPayee
for i in range(1, 35):
    for x in range (1,3):
        if(x ==1):
            payeeId = random.randint(1,7)
        else:
            payeeId = random.randint(8,14)
        amount  = random.randint(10,25)
        accountNumber = i                     
        sqlscript.write("insert into MyPayee(amount, accountNumber, payeeId) values (%i,%i,%i);\n" %(amount, accountNumber, payeeId))

#Bills
for i in range (1,101):
    isPaid= random.randint(0,1)
    if(isPaid==0):
        amount= random.randrange(500, 900)
    else:
        amount =0
    myPayeeId = random.randint(1,34)
    dueDate = str(2018)+"-"+ str(random.randint(11,12))+"-"+str(random.randrange(1,28))
    sqlscript.write("INSERT INTO Bills( amount, isPaid, myPayeeId, dueDate, AutoPay) values ( %i, %i,%i,'%s',%i);\n" %(amount, isPaid, myPayeeId, dueDate,0))
