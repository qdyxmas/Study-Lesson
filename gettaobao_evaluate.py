#coding=utf8
import json
import requests
import re,sys,os
import json
import random
import time
all_data=[]
def cur_file_dir():
     #获取脚本路径
     path = sys.path[0]
     #判断为脚本文件还是py2exe编译后的文件，如果是脚本文件，则返回的是脚本的目录，如果是py2exe编译后的文件，则返回的是编译后的文件路径
     if os.path.isdir(path):
         return path.decode('gbk')
     elif os.path.isfile(path):
         return os.path.dirname(path).decode('gbk')
path=cur_file_dir()
def W15E(pagenum):
    return """https://rate.tmall.com/list_detail_rate.htm?itemId=540881772595&spuId=708409303&sellerId=2176048624&order=3&currentPage="""+str(pagenum)+"""&append=0&content=1&tagId=&posi=&picture=&ua=098%23E1hvb9vRvPpvUvCkvvvvvjiPP2LyAjinR2q9gjthPmPw6ji2PFzZ0jibn2SUljiRRphvCvvvphvtvpvhvvCvpvGCvvpvvPMMvphvC9mvphvvvvyCvhQCeHHBjO97%2Bu0Owos6f4g7%2Bul1ojc6VC46553R6n97RqJ6EvLvqbVQKfE9Z%2BsIRfUTKFEw9E7reEAKNB3rl8T7eCODN%2BLZdigBK7ERKphv8vvvphvvvvvvvvCHhQvvvZpvvhZLvvmCvvvvBBWvvvH1vvCHhQvvvcVEvpvVvpCmpYFvuphvmvvvpBtE%2Fy%2BLiQhvCvvvpZpjvpvjzYMwzHiwNsyCvvpvvhCv3QhvCvmvphmrvpvEvvHDOEZvv2PU9phv2nMSP51A7rMNz1rIzv%3D%3D&isg=Ah0dKPGYGEyatPxNLJV0wy3TLPnXklKtCrlrB9_iEnSxljzIpohyXINEtLxr&needFold=0&_ksTS=1508921770968_2511&callback=jsonp2512"""
for j in range(1,100):
    url=W15E(j)
    while True:
        try:
            cont=requests.get(url).content
            break
        except Exception,e:
            pass
    rex=re.compile(r'\w+[(]{1}(.*)[)]{1}')
    content=rex.findall(cont)[0]
    con=json.loads(content,"gbk")
    try:
        count=len(con['rateDetail']['rateList'])
        # print "count=",count
        # print con['rateDetail']['rateList'][0]['rateContent']
        for i in xrange(count):
            curdta=con['rateDetail']['rateList'][i]['rateContent']
            # curdta=con['rateDetail']['rateList'][i]['next']
            all_data.append(curdta)
        # print all_data
    except Exception,e:
        continue
        # break
    num=random.randint(1,5) 
    time.sleep(num)
filename=os.path.join(path,"W15E.txt").replace("\\","/")
print "filename=",filename
fd=open(filename,"a+")
num=1
for i in all_data:
    data=i.replace("<b>","").replace("</b>","")
    fd.write("%d: " %(num)+data.encode('utf8')+"\n")
    fd.flush()
    num=num+1
fd.close()
