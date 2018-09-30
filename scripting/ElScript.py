from random import*
from math import *

def mix(ar1):
        ar1[k*2]=ar1[1000+k]

def randomize(ar1):
    count=0;
    for k in ar1:
        if count< (floor(len(ar1)*.8)):
            ar1[count]=randint(0, 10)
        else:
            ar1[count]=randint(11, 100)
        count=count+1
    
randarr=[1,2,3,4,5,6,7,8,9,10]       
sqlscript= open("script.mysql", "w",encoding="utf-8")
names= open("names.txt", "r")  
streets= open("streets.txt","r")
cities= open("cities.txt", "r", encoding="utf-8")

#branch
bID=0
blocation=" 'Cote Des Neiges'"
bphone = 5148237115
bfax= 180004563333
bopeningDate = str(randint(1950,2018))+"-"+str(randint(1,12)).zfill(2)+"-"+str(randint(1,28))
bserviceId = str(randint(1,4))

#employee
eaddress="'1770 Joseph Manseau, Montreal Canada'"
estartDate= str(randint(1950,2018))+"-"+ str(randint(1,12)).zfill(2)+"-"+str(randint(1,28))
esalary= 80000
ename="Benyamin"
eemail= ("'"+str(randint(0,270))+ ename+ "@bank.com" +"'").lower()
ephone = 5148888
ecategory="'Managment'"


#arrays
carr = []
narr = []
sarr=[]
posarr=["Loan Officer", "Financial Analyst","Financial Analyst","Bank Teller","Bank Teller","Bank Teller", "Bank Teller", "Loan Officer", "Loan Officer", "Loan Officer", "Loan Officer","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Bank Teller","Bank Teller","Bank Teller","Bank Teller", "Bank Teller", "Loan Officer", "Loan Officer", "Loan Officer", "Loan Officer", "Loan Officer"]
typearr=["'checking'","'savings'", "'investment'","'credit card'","'Line of Credit'"]

for k in range(0,1000):
        carr.append(cities.readline().rstrip())
        if carr[k].find("'") != -1 :
            temp = carr[k]
            front = temp[0:carr[k].find("'")]
            end= temp[carr[k].find("'"):len(temp)]
            carr[k]=front+"\\"+end
        
for j in range(0, 2000):   
        sarr.append(streets.readline().rstrip())         
        narr.append(names.readline().rstrip())
        
    
mix(narr)
#the following are counters for the number of account, clients, and employees
ecount=1
ccount=1
acount=1
for i in range (0,5):
    bID=bID+1
    bopeningdate=str(randint(1950,2018))+"-"+ str(randint(1,12)).zfill(2)+"-"+str(randint(1,28))
    sqlscript.write("insert into branch (id, location, phone, fax, openingDate, managerId, serviceId) values (" 
                    +str(bID)+ ","+blocation+ ","+str(bphone)+ ","+str(bfax)+ ",'"+ bopeningDate + "',"+str(ecount)+","+bserviceId +"); \n" )
    sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    + str(ecount)+ ", 'Branch Manager','"+ename+ "',"+eaddress+ ",'"+estartDate+ "',"+ str(esalary)+ ","+eemail+ ","+str(ephone)+ ","+ecategory+ ","+str(bID)+"); \n" )
    
    randomize(randarr)
    
    ecount=ecount+1
    
    city = carr[randarr[randint(0,9)]]
    blocation= "'"+ str(randint(0,9999))+ " " + sarr[i*2]+", "+ city+"'" 
    bphone = 5140000000 + randint(0,9999999)
    bfax= 18000000000 + randint(0,9999999) 
    bserviceId = str(randint(1,4))
   
    
    ename= narr[i]
    eaddress= "'"+ str(randint(0,9999))+ " " + sarr[i*2+1]+", "+ carr[i]+"'"
    estartDate=str(randint(1950,2018))+"-"+ str(randint(1,12))+"-"+str(randint(1,28))
    esalary=randint(120000, 300000)
    eemail=("'"+str(randint(0,270))+ ename+ "@bank.com" +"'").lower()
    ephone=5140000000 + randint(0,9999999)
    ecategory="'Managment'"
    for j in range (0,5):  
        address = "'"+ str(randint(0,9999))+ " " + sarr[randint(0,500)]+", "+ city+"'"
        startDate=str(randint(1950,2018))+"-"+ str(randint(1,12)).zfill(2) +"-"+str(randint(1,28))
        salary=randint(40000, 120000)
        name=narr[randint(0,500)]
        email=("'"+str(randint(0,270))+ name+ "@bank.com" +"'").lower()
        phone=5140000000 + randint(0,9999999)       
        sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    +str(ecount)+ ",'"+ posarr[j]+"','"+name+ "',"+address+ ",'"+startDate+ "','"+ str(salary)+ "',"+email+ ","+str(phone)+ ","+"'Banking'"+ ","+str(bID)+"); \n" )
        ecount=ecount+1
    for k in range(0,10):
        cname=narr[randint(0,1000)]
        dOB = str(randint(1950,2018))+"-"+ str(randint(1,12)).zfill(2) +"-"+str(randint(1,28))
        joiningDate= str(randint(1950,2018))+"-"+ str(randint(1,12)).zfill(2)+"-"+str(randint(1,28))
        caddress="'"+ str(randint(0,9999))+ " " + sarr[randint(0,500)]+", "+ city+"'"
        cemail=("'"+str(randint(0,270))+ cname+ "@gmail.com" +"'").lower()
        cphone= phone=5140000000 + randint(0,9999999)
        chargePlanId=  str(randint(1,2))
        transactions=randint(0,15000)
        sqlscript.write("insert into client (id, name, dOB, joiningDate, address, email, phone, category, branchId, password, transactions) values (" 
                    +str(ccount)+ ",'"+cname+"',"+dOB+ ",'"+joiningDate+ "',"+caddress+ ","+cemail+ ","+str(cphone)+ ","+"'Banking'"+","+str(bID)+",'password',"+str(transactions) +"); \n" )   
        ccount=ccount+1
        value = 500
        for a in range(0,randint(0,3)):
            balance = randint(5000,15000)
            if ((bserviceId=="2" or bserviceId=="4") and (transactions >value )) :
                ran=randint(1,6)
                if(ran == 4):
                    chargePlanId = "3"
                    type=typearr[3]
                    interestRateId= "4"
                elif(ran >4):
                    chargePlanId = str(randint(4,5))
                    type=typearr[4]
                    interestRateId= str(ran)
                else:
                    type=typearr[ran-1]
                    interestRateId= str(ran)
                    chargePlanId=str(ran)
            else:
                ran=randint(0,1)
                type=typearr[ran]
                interestRateId= str(ran+1)
                chargePlanId= str(randint(1,2))
            
            
            sqlscript.write("insert into account (accountNum, clientId, type, interestRateId, chargePlanId, balance) values(" +str(acount)+ ","+str(ccount-1)+","+type+ ","+interestRateId+ ","+chargePlanId+","+str(balance)+ "); \n")
            
            acount=acount+1

sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    + str(ecount)+ ", 'President','Johnny','12800 rue sherbrooke, Montreal, Qc','"+estartDate+ "',1,'president@bank.com',5140099000,'managment',1); \n" )
ecount = ecount+1           
sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    + str(ecount)+ ", 'GM of Banking','Ben','18030 rue sherbrooke, Montreal, Qc','"+estartDate+ "',1,'gmb@bank.com',5140004400,'managment',1); \n" )
ecount = ecount+1
sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    + str(ecount)+ ", 'GM of Investment','Linda','18003 rue sherbrooke, Montreal, Qc','"+estartDate+ "',1,'gminv@bank.com',5140220000,'managment',1); \n" )
ecount = ecount+1
sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    + str(ecount)+ ", 'GM of Insurance','Charlotte','18010 rue sherbrooke, Montreal, Qc','"+estartDate+ "',1,'gmins@bank.com',5140000045,'managment',1); \n" )

sqlscript.write("insert into bank (bankName, presidentId, bankingGMId, investmentGMId, insuranceGMId)  values ('BKCAJ Bank',"+str(ecount-3)+", "+str(ecount-2)+", "+str(ecount-1)+", "+str(ecount)+"); \n")           

sqlscript.write("insert into client (id, name, dOB, joiningDate, address, email, phone, category, branchId, password, transactions) values ("+str(ccount)+",'Roberto', '1979-10-10','1999-10-10', '1124 grosvenor avenue, Montreal', 'roberto@bank.com', 5146767676,'banking', 1 , 'password', 7000);")

sqlscript.close()
names.close()
streets.close()


    
#("insert into employee (id, title, name, address, startDate, salary, email, address, phone, category, branchID) values (" + str(bID)+ ", 'manager',"+address+ ","+startDate+ ","+ salary+ ","+email+ ","+phone+ ","+category+ ","+str(BID"); \n" )


#branch (branch_id, location, phone, fax, opening_date, manager_name, etc.)