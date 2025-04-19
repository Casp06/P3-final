import allure
from selenium.webdriver.common.by import By

@allure.feature("Inicio")
@allure.story("Carga del sitio")
@allure.title("Verificar que la página principal carga correctamente")
def test_inicio_carga(driver):
    with allure.step("Abrir la página principal"):
        driver.get("http://localhost/logincopia/")

    with allure.step("Verificar que el título contenga 'Visenzzo'"):
        assert "Visenzzo" in driver.title
