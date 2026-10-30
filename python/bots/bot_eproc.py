import time
from bs4 import BeautifulSoup
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import undetected_chromedriver as uc

def rodar_eproc(usuario, senha, numero_processo):
    options = uc.ChromeOptions()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    driver = uc.Chrome(options=options)

    try:
        # 1. Acessa o eproc alvo
        driver.get("https://trf4.jus.br") # Exemplo TRF4
        aguardar = WebDriverWait(driver, 15)

        # 2. Preenche os campos do eproc
        campo_login = aguardar.until(EC.presence_of_element_located((By.ID, "txtUsuario")))
        campo_senha = driver.find_element(By.ID, "txtSenha")
        botao_entrar = driver.find_element(By.ID, "sbmEntrar")

        campo_login.send_keys(usuario)
        campo_senha.send_keys(senha)
        botao_entrar.click()

        # 3. Confirma entrada validando um elemento do menu esquerdo
        aguardar.until(EC.presence_of_element_located((By.ID, "divMenu")))

        # --- EXTRAÇÃO COM BEAUTIFULSOUP ---
        html_puro = driver.page_source
        soup = BeautifulSoup(html_puro, 'lxml')

        # Raspagem simulada dos dados das tabelas do eproc
        return {
            "sucesso": True,
            "processo": {
                "num_processo": numero_processo,
                "tipo_processo": "Procedimento do Juizado Especial Cível",
                "vara_processo": "3ª Vara Federal",
                "comarca": "Porto Alegre",
                "tribunal_processo": "eproc",
                "status_processo": "Ativo",
                "data_abertura_processo": "2026-01-10"
            },
            "audiencias": [
                {
                    "data_audiencia": "2026-11-14 15:00:00",
                    "tipo_audiencia": "Conciliação",
                    "local_audiencia": "CEJUSC Federal",
                    "status_audiencia": "Agendada",
                    "link_audiencia": "https://microsoft.com"
                }
            ]
        }

    except Exception as e:
        raise Exception(f"Falha no motor eproc: {str(e)}")
    finally:
        driver.quit()
