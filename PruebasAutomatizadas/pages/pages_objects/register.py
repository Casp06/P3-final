from selenium.webdriver.common.by import By

class Register:
    userInput = (By.ID, "usuario")
    passwordInput = (By.ID, "password")
    loginButton = (By.XPATH, "//button[@type='submit']")