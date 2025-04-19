from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import pytest

def test_login_exitoso(driver):
    driver.get("http://localhost/logincopia/productos.php")
    driver.find_element(By.ID, "usuario").send_keys("usprueba")
    driver.find_element(By.ID, "password").send_keys("123")
    driver.find_element(By.XPATH, "//button[@type='submit']").click()
    assert "Todos los productos" in driver.page_source, "El texto de bienvenida no está presente en la página"

def test_area_hombre(driver):
    driver.get("http://localhost/logincopia/productos.php")
    driver.find_element(By.XPATH, "/html/body/div/aside/nav/ul/div/button").click()
    driver.find_element(By.XPATH, "//*[@id='hombre']").click()
    assert "Hombre" in driver.page_source, "El texto de bienvenida no está presente en la página"

def test_area_mujer(driver):
    driver.get("http://localhost/logincopia/productos.php")
    driver.find_element(By.XPATH, "/html/body/div/aside/nav/ul/div/button").click()
    driver.find_element(By.XPATH, "//*[@id='mujer']").click()
    assert "Mujer" in driver.page_source, "El texto de bienvenida no está presente en la página"
