#coding=utf-8
import time
import os,sys
from selenium import webdriver
def cur_file_dir():
    #获取脚本路径
    path = sys.path[0]
    #判断为脚本文件还是py2exe编译后的文件，如果是脚本文件，则返回的是脚本的目录，如果是py2exe编译后的文件，则返回的是编译后的文件路径
    if os.path.isdir(path):
        return path.decode('gbk')
    elif os.path.isfile(path):
        return os.path.dirname(path).decode('gbk')
current_path=cur_file_dir();
logfile=os.path.join(current_path,time.strftime("%Y%m%d_%H%M%S",time.localtime()))
logfile=(logfile+".log").replace("\\","/")

class Performance:
    def __init__(self,driver,urllist):
        self.driver=driver
        for url in urllist:
            if not url.startswith("http"):
                url="http://"+url;
            # self.url[url] = url
            # print "self.url=",self.url[url]
            self.driver.execute_script('window.open("%s");' %(url))
    def getallloadtime(self,urllist):
        urlist_time=[]
        windows=self.driver.window_handles
        for i in windows:
            self.driver.switch_to_window(i)
                # self.driver.get(self.url)
            if self.driver.current_url == u"data:,":
                continue
            self.performtime=self.driver.execute_script("return window.performance || window.webkitPerformance || window.mozPerformance || window.msPerformance;")
            urlist_time.append([self.driver.current_url,self.loadWebTime()])
        return urlist_time
    def earliest_timestamp(self):
        timedict=self.performtime['timing']
        if timedict['navigationStart'] > 0:
            return timedict['navigationStart']
        elif timedict['redirectStart'] > 0:
            return timedict['redirectStart']
        elif timedict['redirectEnd'] > 0:
            return timedict['redirectEnd']
        elif timedict['fetchStar'] > 0:
            return timedict['fetchStar']
        
    def latest_timestamp(self):
        timedict=self.performtime['timing']
        if timedict['loadEventEnd']>0:
            return timedict['loadEventEnd']
        elif timedict['loadEventStart']>0:
            return timedict['loadEventStart']
        elif timedict['domComplete']>0:
            return timedict['domComplete']
        elif timedict['domContentLoadedEventEnd'] >0:
            return timedict['domContentLoadedEventEnd']
        elif timedict['domContentLoadedEventStart'] >0:
            return timedict['domContentLoadedEventStart']
        elif timedict['domInteractive']>0:
            return timedict['domInteractive']
        else:
            return timedict['responseEnd']
    def loadWebTime(self):
        return (self.latest_timestamp()-self.earliest_timestamp())/1000.0


if __name__ == "__main__":
    fd = open(logfile,"a+")
    #测试总次数
    testnum=100
    chrome_options= webdriver.ChromeOptions()
    # user_data_dir = os.getenv("APPDATA")+r"\Local\Google\Chrome\User Data"
    # chrome_options.add_argument("user-data-dir="+user_data_dir)
    for i in range(1,testnum):
        #需要打开的url列表网站,直接在下面urllist中添加即可urllist=["url1","url2","url3"]
        urllist=["www.baidu.com","www.qq.com"]
        driver=webdriver.Chrome(chrome_options=chrome_options)
        cli=Performance(driver,urllist)
        for i in cli.getallloadtime(urllist):
            print i[0],":",i[1]
            fd.write(i[0]+":"+str(i[1])+"\n")
            fd.flush()
        driver.quit()
    fd.close()