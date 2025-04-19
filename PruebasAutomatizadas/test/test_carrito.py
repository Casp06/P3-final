from selenium.webdriver.common.by import By

def test_agregar_producto_al_carrito(driver):
    driver.get("http://localhost/logincopia/detalles.php?id=5&token=3b7501b0de9320d755dce29fbfce137a2e7eec78")

    driver.find_element(By.XPATH, "//*[@id='5']").click()     
    assert "Camiseta con Estampado 3D" in driver.page_source  

def test_cambios_al_carrito(driver):
    driver.get("http://localhost/logincopia/detalles.php?id=5&token=3b7501b0de9320d755dce29fbfce137a2e7eec78")

    driver.find_element(By.XPATH, "//*[@id='5']").click() 
    driver.find_element(By.XPATH, "//*[@id='carrito-productos']/div/div[2]/p/button[2]").click()
    
    assert "2" in driver.page_source  

def test_eliminar_producto_del_carrito(driver):
    driver.get("http://localhost/logincopia/detalles.php?id=5&token=3b7501b0de9320d755dce29fbfce137a2e7eec78")

    driver.find_element(By.XPATH, "//*[@id='5']").click() 
    driver.find_element(By.XPATH, "//*[@id='carrito-productos']/div/div[2]/p/button[2]").click()
    driver.find_element(By.XPATH, "//*[@id='5']/i").click()

    assert "Tu carrito está vacío." in driver.page_source 

def test_finalizar_compra(driver):
    driver.get("http://localhost/logincopia/detalles.php?id=5&token=3b7501b0de9320d755dce29fbfce137a2e7eec78")

    driver.find_element(By.XPATH, "//*[@id='5']").click() 
    driver.find_element(By.XPATH, "//*[@id='carrito-productos']/div/div[2]/p/button[2]").click()
    driver.find_element(By.XPATH, "//*[@id='carrito-acciones-comprar']").click()

    assert "Detalles de pago" in driver.page_source 