import pytest
from selenium import webdriver
import allure
import os

@pytest.fixture
def driver(request):
    driver = webdriver.Chrome()

    yield driver

    if request.node.rep_call.failed or request.node.rep_call.passed:
        screenshot_path = os.path.join("screenshots", f"{request.node.name}.png")
        os.makedirs("screenshots", exist_ok=True)
        driver.save_screenshot(screenshot_path)
        allure.attach.file(screenshot_path, name="Captura", attachment_type=allure.attachment_type.PNG)

    driver.quit()


@pytest.hookimpl(hookwrapper=True)
def pytest_runtest_makereport(item, call):
    outcome = yield
    rep = outcome.get_result()
    setattr(item, "rep_" + rep.when, rep)
