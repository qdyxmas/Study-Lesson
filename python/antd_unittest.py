# __author__ = "qdyxmas"
# __version__ = "0.0.1"
import copy
import datetime
import json
import os
import shutil
import sys
import time
import re
import requests
import subprocess

G_commit_id = sys.argv[1]
G_build_id = sys.argv[2]
G_source_brance_name = sys.argv[3]
G_test_name = sys.argv[4]
G_target_brance_name = sys.argv[5]


def cur_file_dir():
    # 获取脚本路径
    path = sys.path[0]
    if os.path.isdir(path):
        return path
    elif os.path.isfile(path):
        return os.path.dirname(path)


path = cur_file_dir()
print("path=", path)

false = False
true = True
filename = "json_data"
G_service_name = "new_xkadmin"
root_dir = "/data/www/html/{}".format(G_service_name)
rootdir = os.path.dirname(os.path.realpath(__file__))

class Js_Unittest():
    def __init__(self):
        self.project_id = 60
        self.source_branch = G_source_brance_name
        self.target_branch = G_target_brance_name
        self.commit_id = self.current_checkout_commit_id()
        self.timestr = self.get_timestr()
        self.unittest_root_dir = path
        self.report_root_dir = "/data/www/html/{}/{}".format(G_service_name,self.timestr)
        self.report_root_template_dir = "/data/www/html/{}".format(G_service_name)

        self.headers = {"PRIVATE-TOKEN": "xxxxxxxxxxxxxxxxxxxxxxx"}
        self.console_log_file = "/data/www/html/{}/log".format(G_service_name)
        # self.error_template_file =
        self.log_file_template =  "/data/www/html/template_pep8.html"
        self.log_file = "{}/pep8.html".format(self.report_root_dir)
    def get_coverage(self):
        coverage = '/data/www/html/{}/{}/coverage/lcov-report/index.html'.format(G_service_name,self.timestr)
        cmd = 'cat %s |grep -B 2 Lines|grep "strong"' % (coverage)
        try:
            cov_string = os.popen(cmd).readline()
            return_string = re.findall(r'(>.*<)', cov_string)[0]
        except Exception as err:
            print("get_coverage error:", err)
            return_string = None
        if return_string:
            return return_string[1:-1]
        else:
            return '-1%'


    def current_checkout_commit_id(self):
        cmd = "git show|grep commit"
        dirname = rootdir
        os.chdir(dirname)
        result = os.popen(cmd).readline()
        result = result.strip().split(" ")[1]
        print("result_commit_id=",result)
        if result != G_commit_id:
            return result
        else:
            return G_commit_id

    def get_timestr(self):
        start_time = datetime.datetime.now()
        timestr = '{}'.format(start_time.strftime("%Y-%m-%d-%H-%M-%S"))
        return timestr

    def create_log_dir(self):
        os.mkdir(self.report_root_dir)

    def get_filename_list(self):
        filename_list = []
        cmd = "git show|grep diff"
        cmd = '''git diff origin/{} origin/{} |grep "diff --git"'''.format(G_source_brance_name, G_target_brance_name)
        os.chdir(self.unittest_root_dir)
        alllist = os.popen(cmd).readlines()
        sys.stdout.write(str(alllist))
        for filename in alllist:
            filepath = re.search(r"/.* ", filename)
            if filepath:
                filename = filepath.group(0)
                filename = os.path.join(self.unittest_root_dir, filename[1:]).replace("\\", '/')
                filename = filename.strip()
                print("filename=", filename)
                if os.path.exists(filename):
                    filename_list.append(filename)
        # sys.stdout.write("filelist=" + str(filename_list))
        return filename_list

    def check_prettier_is_done(self):
        """判断风格检查文件是否检查完成"""
        pass
        return True

    def check_prettier_style(self):
        shutil.copy2(self.log_file_template, self.log_file)
        fd = open(self.log_file, 'r+', encoding='utf8')

        tmpstr = ""
        infos = ""
        allstr = ""
        cmd = """prettier --write 'src/**/*' >log 2>&1 """
        subprocess.call(cmd, shell=True, timeout=600)
        ret = os.popen("""cat log |grep -v 'ms' """)
        cmd_result = ret.readlines()
        print("result=", cmd_result)
        fail_flag = 1
        if len(cmd_result) == 0:
            fail_flag = 0
        tmpstr = tmpstr + "<h2>风格检查结果:</h2>"
        tmpstr = tmpstr + "<pre>"
        i = 1
        for info in cmd_result:
            infos = infos + "<code>{}. ".format(i) + info + "</code>"
            i = i + 1
        allstr = allstr + tmpstr + infos + "</pre>"
        content = fd.read().replace("""${resultData}""", allstr)
        if fail_flag == 1:
            return_code = 'Fail'
            # sys.stdout.write("代码风格检查Fail\n")
        else:
            # sys.stdout.write("代码风格检查Pass\n")
            return_code = 'Pass'
        fd.close()
        fd = open(self.log_file, 'w+', encoding='utf8')
        fd.write(content)
        fd.close()
        return return_code


    def send_test_result_message_to_github(self, codestyle, flag=0):
        coverage = self.get_coverage()
        coverage = coverage.strip()
        unittest_result = self.get_result_info()
        unit_test_result = 'failed'
        if unittest_result.find("Fail:0,Error:0,Skip:0") > 0:
            unit_test_result = 'success'
        codestyle_dict = {"Pass": "success", "Fail": "failed"}
        coverage_url = "http://xkool:xkoollkniubi888@xkooltest.3322.org:9191/%s/%s" % (G_service_name,self.timestr)
        unittest_url = "http://xkool:xkoollkniubi888@xkooltest.3322.org:9191/%s/%s/" % (G_service_name,self.timestr)
        if flag == 1:
            coverage_url = error_url
            unittest_url = error_url
        retry_body = '''{
          "state": "success",
          "target_url": "http://xkool:xkoollkniubi888@xkooltest.3322.org:9191/cgi-bin/index.py?service=%s&build_id=%s",
          "description": "重新运行单测",
          "context": "Retry Unittest"
        }''' % ("test_xkadmin", G_build_id)
        coverage_body = '''{
          "state":"success",
          "target_url":"%s",
          "description":"%s",
          "coverage": "%s",
          "context":"Coverage"
        }''' % (coverage_url, coverage, coverage[:-1])
        codestyle_body = '''{
          "state":"%s",
          "target_url":"http://xkool:xkoollkniubi888@xkooltest.3322.org:9191/%s/%s/pep8.html",
          "description":"%s",
          "context":"Style Check Result"
        }''' % (codestyle_dict[codestyle], G_service_name,self.timestr, codestyle)
        unittest_body = '''{
          "state":"%s",
          "target_url":"%s",
          "description":"{%s}",
          "context":"Unit Test Result"
        }''' % (unit_test_result, unittest_url, unittest_result)
        send_list = [coverage_body,codestyle_body, unittest_body]
        self.call_github_api(1,*send_list)
        return True


    def check_merge_source_not_check(self, dirname, return_code="Pass"):
        white_branch_list = ['release_candidate', 'master', 'dev']
        context_list = ["Coverage", "Unit Test Result"]

        codestyle_dict = {"Pass": "success", "Fail": "failed"}
        body = '''{
            "state":"success",
            "target_url":"http://xkooltest.3322.org:9191",
            "description":"Pass (Special branch not check)",
            "context":"%s"
            }'''
        send_list = []
        for context in context_list:
            send_list.append(body % (context))
        if G_target_brance_name in white_branch_list or G_target_brance_name.startswith("hotfix_"):
            return True
        else:
            self.call_github_api(1,*send_list)
            return False


    def call_github_api(self, flag=1,*sendmsg):
        url = 'https://git.xkool.org/api/v4/projects/{}/statuses/{}'.format(self.project_id, self.commit_id)
        pending_data = {
                "state": "pending",
                "target_url": "http://xkool:xkoollkniubi888@xkooltest.3322.org:9191/{}/log".format(G_service_name),
                "description": "pipeline is running...",
                "context": "Unit Test Result"
            }
        if flag:
            for body in sendmsg:
                for x in range(3):
                    try:
                        data = eval(body)
                        req = requests.post(url, json=data, headers=self.headers)
                        #print("send_body=",body)
                        print(req.content)
                        if req.status_code == 201 or req.status_code == 200:
                            break
                    except Exception as err:
                        print('Exception: ', err)
        else:
            # get_commit_id_is_closed(commit_id)
            req = requests.post(url, json=pending_data, headers=self.headers)
            #print(req.content)
            print(req.status_code)
            if req.status_code == 404:
                sys.exit(0)
        return True


    def get_result_info(self):
        filename = os.path.join(rootdir,"coverage/test-results.json")
        with open(filename, 'r') as f:
            json_data = json.load(f)
        test_results_list = json_data["testResults"]
        result_data = dict()
        result_data["testName"] = 'qdy@xkool.xyz'
        result_data["beginTime"] = ''
        result_data["totalTime"] = ''
        result_data['testResult'] = []
        result_data["testPass"] = json_data["numPassedTests"]
        result_data["testAll"] = json_data["numTotalTests"]
        result_data["testFail"] = json_data["numFailedTests"]
        result_data["testSkip"] = 0
        result_data["testError"] = 0
        for result_dict in test_results_list:
            sub_results_list = result_dict["testResults"]
            case_data = {}
            case_data["className"] = result_dict["testFilePath"][44:]
            if sub_results_list:
                for testcase in sub_results_list:
                    func_full_name = testcase["fullName"]
                    case_data["methodName"] = func_full_name
                    if testcase["status"] == "passed":
                        case_data["status"] = "成功"
                    elif testcase["status"] == "failed":
                        case_data["status"] = "失败"
                    case_data["log"] = " ".join(testcase['failureMessages'])
                    result_data['testResult'].append(copy.deepcopy(case_data))
        index_file = "{}/index.html".format(self.report_root_dir)
        print("testAll=",result_data['testAll'])
        if result_data["testAll"] != 0:
            shutil.copy2("%s/template.html" % (self.report_root_template_dir), index_file)
        else:
            shutil.copy2("%s/java_error_template.html" % (self.report_root_template_dir), index_file)
            os.system("cp -R {}/java_error_template.html {}".format(self.report_root_template_dir, index_file))
            result_data = os.popen("cat /data/www/html/{}/log".format(G_service_name)).readlines()
            result_data = "".join(result_data)
            error_count = "100"
        with open(index_file, "r+", encoding='utf-8') as f:
            if isinstance(result_data, dict):
                content = f.read().replace(r"${resultData}", json.dumps(result_data, ensure_ascii=False, indent=4))
            else:
                content = f.read().replace(r"${resultData}", result_data)
            f.seek(0)
            f.write(content)
        self.copy_file_to_dirname()
        os.system("""esc=$'\e'""")
        os.system("""sed -i "s/$esc\[[0-9;]*m//g" {}""".format(index_file))
        return "Pass:%s,Fail:%s,Error:%s,Skip:%s" % (result_data["testPass"], result_data["testFail"], 0, 0)


    def copy_file_to_dirname(self):
        os.system("cp -R {}/coverage /data/www/html/{}/{}/".format(self.report_root_template_dir,G_service_name ,self.timestr))
        os.system("cp -R /data/www/html/{}/log /data/www/html/{}/{}/log".format(G_service_name,G_service_name,self.timestr))


    def send_dingding(self):
        url = 'https://oapi.dingtalk.com/robot/send?access_token=9abd2d571e04062a758732ec2b37b2c01e69b4249e24a37a68a76916028c4759'
        # 下面为以后实际使用的钉钉接口,上面为测试使用的钉钉接口
        url = 'https://oapi.dingtalk.com/robot/send?access_token=70307670ba1c04561e2ba2ecbc376ffa21839c6a44357cc7a54f4572e25fc252'
        headers = {'content-type': 'application/json'}
        link_url = "http://xkool:xkoollkniubi888@xkooltest.3322.org:9191/{}/{}".format(G_service_name,self.timestr)
        datas = {"msgtype": "markdown", "markdown": {
            "title": "单元测试结果",
            "text": "%s单元测试结果:%s" % (G_service_name,link_url)
        }}
        datas = json.dumps(datas)
        try:
            req = requests.post(url, headers=headers, data=datas)
        except:
            pass
        return True


    def check_ng_test_run_status(self):
        # 判断ng test是否运行完毕,如果运行完毕,杀掉进程id
        for i in range(200):
            cmd = '''grep "Writing test results to JSON file /data/www/html/{}/temp/karma-result.json" /data/www/html/{}/log'''.format(G_service_name,G_service_name)
            cmd_result = os.popen(cmd).readline()
            print("cmd_result=",cmd_result)
            if cmd_result:
                pid = os.popen("""ps ax|grep XKool|grep -v grep |awk '{print $1}'""").readline()
                os.system("kill -9 %s" % pid)
                os.system("killall -9 chrome")
                break
            else:
                print("正在测试中,请稍后... %s/200" % (i))
                time.sleep(1)
        return True
    
    
    def npm_build(self):
        build_env = "prod"
        if self.target_branch == "release_candidate":
            build_env = "rc"
        elif self.target_branch == "dev":
            build_env = "dev"
        build_cmd = "npm run build:{}  > /data/www/html/{}/build_log 2>&1".format(G_service_name,build_env)
        subprocess.call(build_cmd, shell=True)
        result_cmd = """grep "ERROR" /data/www/html/{}/build_log""".format(G_service_name)
        cmd_result = os.popen(result_cmd).readline()
        print("cmd_result=",cmd_result)
        result_dict = {"success":"Pass", "failed":"Fail"}
        if cmd_result:
            build_result = "failed"
        else:
            build_result = "success"
        os.system("cp /data/www/html/{}/build_log /data/www/html/{}/{}/build_log".format(G_service_name,G_service_name,self.timestr))
        target_url = "http://xkool:xkoollkniubi888@xkooltest.3322.org:9191/{}/{}/build_log".format(G_service_name,self.timestr)
        build_body = ['''{
          "state":"%s",
          "target_url":"%s",
          "description":"{%s}",
          "context":"npm build Result"
        }''' % (build_result, target_url, result_dict[build_result])]
        self.call_github_api(1,*build_body)
    def is_npm_install(self):
        """根据package.json是否有改变判断是否需要npm install"""
        result = os.popen("git show|grep diff|grep package.json").readline()
        result = result.strip()
        if len(result) > 0:
            subprocess.call("npm install  >> /data/www/html/{}/log".format(G_service_name), shell=True)
        subprocess.call("npm update", shell=True)
        subprocess.call("npm install jest-json-reporter2 >> /data/www/html/{}/log".format(G_service_name), shell=True)
    def update_result_pendding(self):
        """设置为pending"""
        self.call_github_api(0)
        self.is_npm_install()
if __name__ == "__main__":
    test_obj = Js_Unittest()
    test_obj.update_result_pendding()
    test_obj.create_log_dir()
    return_code = test_obj.check_prettier_style()
    flag = 0
    os.system("rm -rf /var/lib/jenkins/workspace/test_new_xkadmin/coverage/*")
    os.system("rm -rf /data/www/html/{}/temp/*".format(G_service_name))
    subprocess.call("""npm run test -- --coverage  > /data/www/html/{}/log 2>&1""".format(G_service_name), shell=True)
    try:
        flag = 2
        # test_obj.check_ng_test_run_status()
        result = test_obj.get_result_info()
    except Exception as err:
        print(err)
        flag = 1
    finally:
        #test_obj.npm_build()    
        test_obj.send_test_result_message_to_github(return_code, flag)
    if 2 == flag:
        test_obj.send_dingding()
        os.system("""echo "npm install running ..."  > /data/www/html/{}/log""".format(G_service_name))
