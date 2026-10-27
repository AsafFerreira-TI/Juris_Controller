import time
from bs4 import BeautifulSoup
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import undetected_chromedriver as uc

def rodar_pje(usuario, senha, numero_processo):
    options = uc.ChromeOptions()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    driver = uc.Chrome(options=options)

    try:
        # 1. Acessa o painel de login padrão do PJe
        driver.get("https://trt2.jus.br") # Exemplo TRT/PJe
        aguardar = WebDriverWait(driver, 20)

        # 2. Localiza campos (PJe costuma usar inputs simples quando não é token)
        campo_user = aguardar.until(EC.presence_of_element_located((By.ID, "username")))
        campo_pass = driver.find_element(By.ID, "password")
        botao = driver.find_element(By.ID, "loginBtn")

        campo_user.send_keys(usuario)
        campo_pass.send_keys(senha)
        botao.click()

        # 3. Aguarda carregar o painel interno
        aguardar.until(EC.presence_of_element_located((By.ID, "painel-advogado")))

        # --- EXEMPLO DE NAVEGAÇÃO E EXTRAÇÃO ---
        # 4. CAPTURA DE IFRAME (O grande segredo do PJe)
        # Se os dados do processo abrirem em uma janela/iframe interno:
        driver.switch_to.frame("corpoIframe")

        html_puro = driver.page_source
        soup = BeautifulSoup(html_puro, 'lxml')

        # Raspagem simulada dos dados das tabelas do PJe
        # (As chaves abaixo batem exatamente com o seu banco Supabase)
        return {
            "sucesso": True,
            "processo": {
                "num_processo": numero_processo,
                "tipo_processo": "Ação Trabalhista - Rito Ordinário",
                "vara_processo": "02ª Vara do Trabalho",
                "comarca": "São Paulo",
                "tribunal_processo": "pje",
                "status_processo": "Ativo",
                "data_abertura_processo": "2026-05-20"
            },
            "audiencias": [
                {
                    "data_audiencia": "2026-12-05 09:30:00",
                    "tipo_audiencia": "Instrução",
                    "local_audiencia": "Sala Virtual JT",
                    "status_audiencia": "Designada",
                    "link_audiencia": "https://zoom.us"
                }
            ]
        }

    except Exception as e:
        raise Exception(f"Falha no motor PJe: {str(e)}")
    finally:
        driver.quit()
