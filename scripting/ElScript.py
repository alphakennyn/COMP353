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
blocation="'Montreal'"
bphone = 5148237115
bfax= 180004563333
bopeningDate = "'01/02/23'" 
bserviceId = "'s"+str(randint(1,4))+"'"

#employee
eaddress="'1770 Joseph Manseau, Montreal Canada'"
estartDate="'01/01/2018'"
esalary= 80000
ename="Benyamin"
eemail= ("'"+str(randint(0,270))+ ename+ "@bank.com" +"'").lower()
ephone = 5148888
ecategory="Managment"


#arrays
carr = []
narr = []
sarr=[]
posarr=["Financial Analyst", "Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Financial Analyst","Bank Teller","Bank Teller","Bank Teller","Bank Teller", "Bank Teller", "Loan Officer", "Loan Officer", "Loan Officer", "Loan Officer", "Loan Officer"]
typearr=["'checking'","'savings'", "'investment'"]

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
for i in range (0,100):
    sqlscript.write("insert into branch (id, location, phone, fax, openingDate, managerId, serviceId) values (" 
                    + "'b"+str(bID)+ "',"+blocation+ ","+str(bphone)+ ","+str(bfax)+ ","+ bopeningDate + ","+ "'e"+str(bID)+"',"+bserviceId +"); \n" )
    sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    + "'e"+str(ecount)+ "', 'Branch Manager','"+ename+ "',"+eaddress+ ","+estartDate+ ","+ str(esalary)+ ","+eemail+ ","+str(ephone)+ ","+ecategory+ ","+"'b"+str(bID)+"'); \n" )
    
    randomize(randarr)
    
    bID=bID+1
    ecount=ecount+1
    city = carr[randarr[randint(0,9)]]
    blocation= "'"+ str(randint(0,9999))+ " " + sarr[i*2]+", "+ city+"'" 
    bphone = 5140000000 + randint(0,9999999)
    bfax= 18000000000 + randint(0,9999999) 
    bserviceId = "'s"+str(randint(1,7))+"'"
    bopeningdate="'"+str(randint(1,30))+"/"+ str(randint(1,12))+"/2018'"
    
    ename= narr[i]
    eaddress= "'"+ str(randint(0,9999))+ " " + sarr[i*2+1]+", "+ carr[i]+"'"
    estartDate="'"+str(randint(1,30))+"/"+ str(randint(1,12))+"/2018'"
    esalary=randint(120000, 300000)
    eemail=("'"+str(randint(0,270))+ ename+ "@bank.com" +"'").lower()
    ephone=5140000000 + randint(0,9999999)
    ecategory="'Managment'"
    for j in range (0,20):
        address = "'"+ str(randint(0,9999))+ " " + sarr[randint(0,500)]+", "+ city+"'"
        startDate="'"+str(randint(1,30))+"/"+ str(randint(1,12))+"/2018'"
        salary=randint(40000, 120000)
        name=narr[randint(0,500)]
        email=("'"+str(randint(0,270))+ name+ "@bank.com" +"'").lower()
        phone=5140000000 + randint(0,9999999)
        sqlscript.write("insert into employee (id, title, name, address, startDate, salary, email, phone, category, branchID) values (" 
                    + "'e"+str(ecount)+ "','"+ posarr[j]+"','"+name+ "',"+address+ ","+startDate+ ",'"+ str(salary)+ "',"+email+ ","+str(phone)+ ","+"'Banking'"+ ","+"'b"+str(bID)+"'); \n" )
        ecount=ecount+1
    for k in range(0,100):
        cname=narr[randint(0,1000)]
        dOB = "'"+str(randint(1,30))+"/"+ str(randint(1,12))+"/"+str(randint(1900,1999))+"'"
        joiningDate= str(randint(1950,2018))+"-"+ str(randint(1,12))+"-"+str(randint(1,30))
        caddress="'"+ str(randint(0,9999))+ " " + sarr[randint(0,500)]+", "+ city+"'"
        cemail=("'"+str(randint(0,270))+ cname+ "@gmail.com" +"'").lower()
        cphone= phone=5140000000 + randint(0,9999999)
        chargePlanId=  "'cp"+str(randint(1,2))+"'"
        sqlscript.write("insert into client (id, name, dOB, joiningDate, address, email, phone, category, branchId) values (" 
                    + "'c"+str(ccount)+ "','"+cname+"',"+dOB+ ","+joiningDate+ ","+caddress+ ","+cemail+ ","+str(cphone)+ ","+"'Banking'"+","+"'b"+str(bID)+"'); \n" )   
        ccount=ccount+1
        for a in range(0,randint(0,3)):
            balance = randint(200,9999999999)
            if (bserviceId=="s2" or bserviceId=="s4") :
                ran=randint(0,2)
                type=typearr[ran]
                interestRateId= "'i"+str(ran+1)+"'"
            else:
                ran=randint(0,1)
                type=typearr[ran]
                interestRateId= "'i"+str(ran+1)+"'"
            
            
            sqlscript.write("insert into account (accountNum, clientId, type, interestRateId, chargePlanId, balance) values(" + "'a"+str(acount)+ "','c"+str(ccount)+"',"+type+ ","+interestRateId+ ","+chargePlanId+","+balance+ "); \n")
            
            acount=acount+1


    
    
    
  
    
    
    
    
           
           
sqlscript.close()
names.close()
streets.close()


    
#("insert into employee (id, title, name, address, startDate, salary, email, address, phone, category, branchID) values (" + str(bID)+ ", 'manager',"+address+ ","+startDate+ ","+ salary+ ","+email+ ","+phone+ ","+category+ ","+str(BID"); \n" )


#branch (branch_id, location, phone, fax, opening_date, manager_name, etc.)