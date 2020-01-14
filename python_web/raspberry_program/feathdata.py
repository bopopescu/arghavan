#pip install mysql-connector-python
import mysql.connector
import requests
import os


os.environ['no_proxy'] = '*' 
RASP_IP="192.168.10.100"  #raspberry Ip address

#database connection
mydb = mysql.connector.connect(
      host="localhost",
      user="user",
      passwd="user",
      database="tempDB"
    )

#insert valid cart into temp database
def insertcart(cartid,gate_ip):
    try:
        mycursor = mydb.cursor()
        sql = "INSERT INTO `gate_datas` ( `cart_number`,`gate_ip`) VALUES ('"+cartid+"','"+gate_ip+"')"
        mycursor.execute(sql)
        mydb.commit()
    except:
        print ("error in insert data cart")

#insert personal data for show in web ui        
def insertperson(code,name,lastname,card):
    try:
        mycursor = mydb.cursor()
        sql = "INSERT INTO `user_datas` ( `cart_number`,`name`,`lastname`,`user_code`) VALUES ('"+card+"','"+name+"','"+lastname+"','"+code+"')"
        mycursor.execute(sql)
        mydb.commit()
    except:
        print ("error in insert person")
#delete all valid person data for fatch new data        
def deleteallperson():
        try:
            mycursor = mydb.cursor()
            sql = "delete from user_datas"
            mycursor.execute(sql)
            mydb.commit()
        except:
            print ("error in delete data person")
#delete all cart from for fatch new data        
def deleteallcart():
    try:
            mycursor = mydb.cursor()
            sql = "delete from gate_datas"
            mycursor.execute(sql)
            mydb.commit()
    except:
        print ("error in delete data delete all cart")        
   
def loadvalidcart():
    r = requests.get('http://192.168.10.90/listAllowTraffic/'+RASP_IP)
    print(r)
    data=r.json()["data"]
    #print(data["data"])
    for item in data:
       insertcart(item["cdn"],item["ip"])
       print(item["cdn"])
        
def loadvalidperson():
    r = requests.get('http://192.168.10.90/listDataUser/'+RASP_IP)
    data=r.json()["data"]
    print (data)
    for item in data:
        insertperson(item["code"],item["name"],item["lastname"],item["cdn"])
        #try:

        #resource = urllib.request.urlretrieve("http://riratech.ir/getUserCDN/"+item["cdn"]+"/image","/tmp/"+itemp["cdn"]+".jpg")
        print("http://192.168.10.90/getUserCDN/"+item["cdn"]+"/image")
        os.system("wget -O /var/www/html/storage/app/public/"+item["cdn"]+".jpg http://192.168.10.90/getUserCDN/"+item["cdn"]+"/image")
        #except:
         #   print ("error ")
            
deleteallcart()       
loadvalidcart()
deleteallperson()
loadvalidperson()
