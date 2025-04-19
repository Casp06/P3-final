from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException

class BaseActions:
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 30)

    def load(self, url):
        self.driver.get(url)
    
    def wait_for_element(self, locator, timeout=30):
        try:
            WebDriverWait(self.driver, timeout).until(
                EC.presence_of_element_located(locator)
            )
            return self.driver.find_element(*locator)
        except TimeoutException:
            print("El element no se encontró en el tiempo especificado.")
            return None

    def elemnt_click(self, locator):
        user = self.wait_for_element(locator)
        if user:
            user.click()
        else:
            print("El elemento no se encontró para hacer clic.")

    def type_info(self, locator, keyword):
        user = self.wait_for_element(locator)
        if user:
            user.send_Keys(keyword)
        else:
            print("El elemento no se encontró para hacer clic.")

    def is_displayed(self, locator) -> bool:
        user = self.wait_for_element(locator)
        if user:
            user.is_displayed()
        else:
            return False
        
    def is_enabled(self, locator) -> bool:
        user = self.wait_for_element(locator)
        if user:
            user.is_enabled()
        else:
            return False
