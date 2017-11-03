#coding=utf-8
import time
import os,sys
from selenium import webdriver
#启动Appnium appium -a 127.0.0.1 -p 4723 -U  LGD857cfd6ea69  --no-reset
#mSurface=Surface(name=com.android.chrome/org.chromium.chrome.browser.ChromeTabbedActivity)
#adb devices
#adb shell getprop ro.build.version.release #查看android版本号
#adb shell getprop ro.build.version.sdk #查看SDK 版本号
#
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
logfile=(logfile+".log").replace("//","/")
class Chrome62:
    #https://github.com/SeleniumHQ/selenium/issues/4971
    #
    def __init__(self,driver):
        self.driver = driver
    def expand_shadow_element(self,element):
        shadow_root = self.driver.execute_script('return arguments[0].shadowRoot', element)
        return shadow_root
    def expand_shadow_element_c(self,element,selector):
        shadow_root = self.driver.execute_script('return arguments[0].querySelector(arguments[1]).shadowRoot', element, selector)
        return shadow_root
    def ClearHistory(self):
        self.driver.get("chrome://settings/clearBrowserData")
        root1 = self.driver.find_element_by_tag_name('body')
        s1 = self.expand_shadow_element_c(root1,'settings-ui')

        root2 = s1.find_element_by_id('container')
        s2 = self.expand_shadow_element_c(root2,'settings-main')

        root3 = s2.find_element_by_css_selector("settings-basic-page")
        s3 = self.expand_shadow_element(root3)

        root4 = s3.find_element_by_id('advancedPage')
        s4 = self.expand_shadow_element_c(root4,"settings-privacy-page")

        root5 = s4.find_element_by_css_selector("settings-clear-browsing-data-dialog")
        s5 = self.expand_shadow_element(root5)
        
        s5.find_element_by_id('clearBrowsingDataConfirm').click()
        time.sleep(2)
    
class Performance:
    def __init__(self,driver,urllist):
        self.driver=driver
        self.urllist=urllist

    def singopen(self):
        time_list = []
        for url in self.urllist:
            if not url.startswith("http"):
                url="http://"+url
            print "url=",url
            self.driver.get(url)
            ret=self.getallloadtime()
            time_list.extend(ret)
        print "time_list=",time_list
        return time_list
    def multiopen(self):
        for url in self.urllist:
            if not url.startswith("http"):
                url="http://"+url;
            # self.url[url] = url
            # print "self.url=",self.url[url]
            # time.sleep(0.5)
            self.driver.execute_script('window.open("%s");' %(url))
        self.getallloadtime()    
    def getallloadtime(self):
        urlist_time=[]
        windows=self.driver.window_handles
        for i in windows:
            while True:
                self.driver.switch_to_window(i)
                    # self.driver.get(self.url)
                if self.driver.current_url in u"data:," or "local" in self.driver.current_url:
                    continue
                self.performtime=self.driver.execute_script("return window.performance || window.webkitPerformance || window.mozPerformance || window.msPerformance;")
                if self.performtime['timing']['loadEventEnd']:
                    urlist_time.append([self.driver.current_url.split("/")[2],self.loadWebTime()])
                    print "loadEndtime=",self.loadWebTime()
                    break
                else:
                    time.sleep(1)
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
        while True:
            if timedict['loadEventEnd']>0:
                return timedict['loadEventEnd']
            time.sleep(1)
        # elif timedict['loadEventStart']>0:
            # return timedict['loadEventStart']
        # elif timedict['domComplete']>0:
            # return timedict['domComplete']
        # elif timedict['domContentLoadedEventEnd'] >0:
            # return timedict['domContentLoadedEventEnd']
        # elif timedict['domContentLoadedEventStart'] >0:
            # return timedict['domContentLoadedEventStart']
        # elif timedict['domInteractive']>0:
            # return timedict['domInteractive']
        # else:
            # return timedict['responseEnd']
    def loadWebTime(self):
        return (self.latest_timestamp()-self.earliest_timestamp())/1000.0


if __name__ == "__main__":
    fd = open(logfile,"a+")
    #测试总次数
    
    testnum=2
    desired_caps = {}
    desired_caps['platformName'] = 'Android'
    desired_caps['appPackage'] = 'com.android.chrome'
    desired_caps['appActivity'] = 'org.chromium.chrome.browser.ChromeTabbedActivity'
    desired_caps['deviceName'] = 'LGD857cfd6ea69'
    desired_caps['platformVersion'] = '5.0.1'
    for i in range(1,testnum):
        #需要打开的url列表网站,直接在下面urllist中添加即可urllist=["url1","url2","url3"]
        urllist=[       
        'www.sina.com.cn','www.baidu.com','www.taobao.com','www.qq.com','www.iqiyi.com']
        #手机的
        # driver = webdriver.Remote('http://localhost:4723/wd/hub', desired_caps)
        #PC的
        driver = webdriver.Chrome()
        #先清除缓存
        # driver.get("chrome://settings/clearBrowserData")
        # driver.switch_to_frame("clearBrowsingDataDialog")
        # driver.find_element_by_id("clearBrowsingDataConfirm").click()
        clears = Chrome62(driver)
        clears.ClearHistory()
        # time.sleep(3)
        # driver.switch_to_frame()
        # driver.get("http://www.baidu.com")
        cli=Performance(driver,urllist)
        timelist=cli.singopen()
        # cli.multiopen()
        time.sleep(3)
        try:
            # timelist=cli.getallloadtime()
            for i in timelist:
                print i[0],":",i[1]
                fd.write(i[0]+":"+str(i[1])+"\n")
                fd.flush()
        except Exception,e:
            pass
        driver.quit()
    fd.close()
