#coding=utf8
import os,sys
import requests
import base64
from pyquery import PyQuery as pq
from bs4 import BeautifulSoup
def cur_file_dir():
     #获取脚本路径
     path = sys.path[0]
     #判断为脚本文件还是py2exe编译后的文件，如果是脚本文件，则返回的是脚本的目录，如果是py2exe编译后的文件，则返回的是编译后的文件路径
     if os.path.isdir(path):
         return path.decode('gbk')
     elif os.path.isfile(path):
         return os.path.dirname(path).decode('gbk')
#打印结果
path = cur_file_dir()
class F306:
    def __init__(self,user="admin",pwd="123",dip="192.168.3.1"):
        self.urllist = ['login.asp']
        self.urldict = {}
        self.url_tag_dict = {}
        self.session  = requests.session()
        self.user = user
        self.pwd = pwd
        self.dip = dip
    def login(self):
        #
        url = "http://%s/login/Auth" %(self.dip)
        data = {"username":self.user,"pass_word":self.pwd,"password":base64.b64encode(self.pwd)}
        ret = self.session.post(url,data=data)
        if ret.url.find("main"):
            print "login suc"
            return True
        else:
            return False
    def parser_login_url(self):
        url = "http://%s/login.asp" %(self.dip)
        root_tag = 'jquery("form").html()'
        data = self.parser_form(url,root_tag,0)
        ret_list=self.parser_html_tag(data)
        self.urldict[url] = ret_list
        return {url:ret_list}
    def parser_home_url(self):
        url = "http://%s/home.asp" %(self.dip)
        root_tag = 'jquery("#main").html()'     
        data = self.parser_form(url,root_tag)
        ret_list=self.parser_html_tag(data)
        self.urldict[url] = ret_list
        return {url:ret_list}
    def parser_form(self,url,root_tag="",flag = 1):
        #接线url中的form表单内容
        ret_list = [] #返回form表单里面的列表
        ret_dict = {}
        if url.endswith("login.asp"):
            flag = 0
        for j in xrange(0,3):
            if flag:
                for i in xrange(1,5):
                    if self.login():
                        break
                    time.sleep(3)
            ret = self.session.get(url)
            # print "ret.text",type(ret.content)
            jquery = pq(ret.content.decode('utf8'))
            # print "content=",content
            data = eval(root_tag)
            if data:
                break
            # print "data=",data
        return data
        # ret_list=self.parser_html_tag(data)
        # self.urllist[url] = ret_list
        # ret_dict[url] = ret_list
        # return ret_dict
    def parser_html_tag(self,element):
        ret_dict={}
        ret_list=[]
        try:
            soup = BeautifulSoup(element)
        except Exception,e:
            print e
            return None
        form_list  = soup.find_all(["input","select"])
        if not form_list:
            return None
        for i in form_list:
            if i.name == "input":
                #对input进行过滤
                ret_list.append(self.input_parser_value(i))
            elif i.name == "select":
                ret_list.append(self.select_parser_value(i))
                #对select_list处理
        return ret_list
    def select_parser_value(self,element):
        ret_dict = {}
        if element.has_key("id"):
            ret_dict = {'id':element.get('id')}
        elif element.has_key("name"):
            ret_dict = {'name':element.get('name')}
        elif element.has_key("class"):
            ret_dict = {'name':element.get('name')}
        ret_dict['type'] = "select"
        return ret_dict
    def input_parser_value(self,element):
        #对返回值进行处理
        # print "element=",element
        ret_dict = {}
        if element.get("type") != "hidden":
            if element.has_key("id"):
                ret_dict = {'id':element.get('id')}
            elif element.has_key("name"):
                ret_dict = {'name':element.get('name')}
            elif element.has_key("class"):
                ret_dict = {'name':element.get('name')}
            ret_dict['type'] = element.get("type")
        return ret_dict
    def get_all_tag(self):
        return self.urldict
    def parser_control_group(self,element):
        #先判断是否有label 标签 如果有则
        ret_dict = {}
        root=pq(element)
        
        desc = root("label[class='control-label']").html()
        if desc:
            # print "desc=",desc
            ret = self.parser_html_tag(element)
            ret_dict[desc] = ret
        return ret_dict
    def parseurl_list(self,urllist):
        for url in urllist:
            new_url = "http://%s/%s" %(self.dip,url)
            root_tag = 'jquery("body").html()'
            # print "new_url=",new_url
            data = self.parser_form(new_url,root_tag)
            ret_list=self.parser_html_tag(data)
            self.urldict[new_url] = ret_list
    def geturls(self,urllist):
        allret = {}
        list_ret = []
        for url in urllist:
            list_ret = []
            new_url = "http://%s/%s" %(self.dip,url)
            root_tag = 'jquery("body").html()'
            data = self.parser_form(new_url,root_tag,flag = 1)
            # print "data=",data
            soup = BeautifulSoup(data)
            # form_list = soup.find_all(attrs={"class":"control-group"})
            form_list = soup.find_all("div",class_="control-group")
            # print "form_list=",form_list
            print len(form_list)
            for i in form_list:
                ret = self.parser_control_group(str(i))
                list_ret.append(ret)
            allret[new_url] = list_ret
        self.url_tag_dict = allret
        return allret
    def printtag(self,urllist):
        filename = os.path.join(path,"result.log")
        fd = open(filename,"a+")
        self.parseurl_list(urllist)
        jc = self.get_all_tag()
        for k,v in jc.iteritems():
            # print k
            fd.write(k+"\n")
            if v:
                for i in v:
                    if i:
                        fd.write(str(i)+"\n")
                print ""*30
                fd.write(""*30+"\n")
    def print_tag_all(self,urllist):
        filename = os.path.join(path,"tag_result.log")
        fd = open(filename,"a+")
        allret = self.geturls(urllist)
        for k,v in allret.iteritems():
            fd.write(k+"\n")
            for i in v:
                for k1,v1 in i.iteritems():
                    fd.write(k1.strip().encode('gbk'))
                    fd.write("\t:\t"+str(v1).strip()+"\n")
                    # print k1,v1
            fd.write("------------------------------\n")
        fd.close()
if __name__ == "__main__":
    urllist = ['wireless/wireless_rfsetting.html', 'wireless/wireless_msg_statistic.html', 'wireless/wireless_filter.html', 'wireless/wireless_extra_setting.html', 'wireless/wireless_client_list.html', 'wireless/wireless_basic_setting.html', 'welcome.asp', 'webpush/webpage_push.html', 'webpush/cloud_ad.html', 'webpage_showpic.asp', 'vpn/pptp_user.html', 'vpn/pptp_server.html', 'vpn/pptp_client_list.html', 'vpn/pptp_client.html', 'upgrading.asp', 'system/system_upgrade.asp', 'system/system_restore.asp', 'system/system_reboot.asp', 'system/system_password.asp', 'system/system_hostname.asp', 'system/system_backup.asp', 'system/simple_upgrading.asp', 'system/simple_upgrade.asp', 'system/schedule_reboot.asp', 'system/policy_upgrade.asp', 'system/policy_success.asp', 'system/password_error.asp', 'status/wan_total_statistic.html', 'status/wan_statistic3.html', 'status/wan_statistic2.html', 'status/wan_statistic1.html', 'status/wan_statistic.html', 'status/traffic_statistic.html', 'status/sys_wireless_status.html', 'status/sys_state.html', 'status/port_state.html', 'safe/ip_mac_bind.html', 'safe/ip_defence.html', 'safe/dynamic_bind.html', 'safe/ddos_defence.html', 'safe/arp_defence.html', 'reboot.asp', 'qos/manual_bandwidth.html', 'qos/auto_traffic.html', 'password_error.asp', 'network/wan_setting.html', 'network/wan_policy.html', 'network/wan_num.html', 'network/wan_access.html', 'network/switch_portVLAN.html', 'network/port_param.html', 'network/mac_clone.html', 'network/lan_setting.html', 'network/lan_access.html', 'network/guest_dhcp_server.html', 'network/guest_dhcp_list.html', 'network/dhcp_static.html', 'network/dhcp_server.html', 'network/dhcp_client_list.html', 'loginerr.html', 'login.asp', 'log/system_log.html', 'log/statistic.html', 'index.asp', 'home.asp', 'error.asp', 'disable.asp', 'direct_reboot.asp', 'device/wizard.html', 'cloudInstructions.html', 'behave/url_policy.html', 'behave/time_group.html', 'behave/port_filter.html', 'behave/mac_filter.html', 'behave/ip_group.html', 'behave/global_url.html', 'behave/defined_url.html', 'behave/account_filter.html', 'advance/usbFileShare.html', 'advance/upnp.html', 'advance/static_routing.html', 'advance/routing_list.html', 'advance/nat_virtual_server.html', 'advance/hotel_mode.html', 'advance/dmz.html', 'advance/ddns.html']
    cc = F306()]
    cc.print_tag_all(urllist)
