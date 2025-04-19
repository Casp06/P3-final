from selenium.webdriver.common.by import By

def test_admin_login_exitoso(driver):
    driver.get("http://localhost/login/admin/")
    driver.find_element(By.ID, "usuario").send_keys("admin")
    driver.find_element(By.ID, "password").send_keys("admin")
    driver.find_element(By.XPATH, "//button[@type='submit']").click()
    assert "Dashboard" in driver.page_source, "El texto de bienvenida no está presente en la página"
