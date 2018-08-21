capabilities = {
          'browserName': 'chrome',
          'chromeOptions':  {
            'prefs': {'download.default_directory': 'D:\\', 'intl.accept_languages': 'zh-CN',"download.prompt_for_download": False},
            'useAutomationExtension': False,
            'forceDevToolsScreenshot': True,
            'args': ['--start-maximized', '--disable-infobars']
          }
}
driver = webdriver.Chrome(desired_capabilities=capabilities)
