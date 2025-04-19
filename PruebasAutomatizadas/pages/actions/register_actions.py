from .base_actions import BaseActions
from pages.pages_objects.register import Register
class RegisterActions:
    def __init__(self, driver):
        super().__init__(driver)

    def type_user(self, user: str):
        self.type_user(Register.userInput, user) 

    def type_user(self, password: str):
        self.type_user(Register.passwordInput, password) 

    def click_ingresar(self):
        self.element_click(Register.loginButton)