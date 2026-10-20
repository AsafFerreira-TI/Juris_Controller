import sys
import json
import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import undetected_chromedriver as uc


def fazer_login(usuario, senha):
    # Inicializa o Chrome de forma indetectável
    options = uc.ChromeOptions()
    options.add_argument('--headless') # Roda sem abrir a janela no servidor
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')

    driver = uc.Chrome(options=options)

    try:
        # 1. Acessa a página de login do e-SAJ (Exemplo: TJSP)
        driver.get("https://esaj.tjsp.jus.br/sajcas/login")

        # 2. Aguarda o campo de usuário carregar
        aguardar = WebDriverWait(driver, 15)
        campo_usuario = aguardar.until(EC.presence_of_element_located((By.ID, "usernameForm")))
        campo_senha = driver.find_element(By.ID, "passwordForm")
        botao_entrar = driver.find_element(By.NAME, "Submit")

        # 3. Insere os dados transmitidos pelo Laravel
        campo_usuario.send_keys(usuario)
        campo_senha.send_keys(senha)

        # 4. Clica no botão para logar
        botao_entrar.click()

        # 5. Aguarda uma URL ou elemento que comprove que o login deu certo (Ex: Menu de opções)
        # Ajustar o ID de acordo com o elemento interno do tribunal após o login
        aguardar.until(EC.presence_of_element_located((By.ID, "menuGeral")))

        # --- A PARTIR DAQUI O ROBÔ ESTÁ LOGADO ---
        # Seu código de busca de processos e BeautifulSoup entra aqui...

        # Mock de resposta de sucesso para o Laravel devolver
        resposta = {
            "sucesso": True,
            "mensagem": "Login efetuado e dados raspados com sucesso.",
            "processos": [],
            "audiencias": []
        }
        print(json.dumps(resposta))

    except Exception as e:
        # Se algo falhar, printa o erro para o Laravel capturar no errorOutput()
        sys.stderr.write(f"Falha na automação: {str(e)}")
        sys.exit(1)

    finally:
        driver.quit()


def rodar_esaj(usuario, senha, numero_processo):
    options = uc.ChromeOptions()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    driver = uc.Chrome(options=options)

    try:
        driver.get("https://esaj.tjsp.jus.br/sajcas/login")
        aguardar = WebDriverWait(driver, 15)

        campo_usuario = aguardar.until(EC.presence_of_element_located((By.ID, "usernameForm")))
        campo_senha = driver.find_element(By.ID, "passwordForm")
        botao_entrar = driver.find_element(By.NAME, "Submit")

        campo_usuario.send_keys(usuario)
        campo_senha.send_keys(senha)
        botao_entrar.click()

        aguardar.until(EC.presence_of_element_located((By.ID, "menuGeral")))

        # --- SEU CÓDIGO DE RASPAGEM (BEAUTIFULSOUP) ENTRA AQUI ---
        # Vamos simular que você coletou as variáveis abaixo do HTML do e-SAJ:
        classe_coletada = "Procedimento Comum Cível"
        vara_coletada = "1ª Vara Cível"
        comarca_coletada = "Capital"
        data_abertura = "2026-03-15"

        # 2. Monte o dicionário usando as chaves exatas das suas colunas do Laravel
        resposta = {
            "sucesso": True,
            "processo": {
                "num_processo": numero_processo,
                "tipo_processo": classe_coletada,
                "vara_processo": vara_coletada,
                "comarca": comarca_coletada,
                "tribunal_processo": "esaj",
                "status_processo": "Ativo",
                "data_abertura_processo": data_abertura
            },
            "audiencias": [
                {
                    "data_audiencia": "2026-11-20 14:30:00", # Padronizado YYYY-MM-DD HH:MM:SS
                    "tipo_audiencia": "Conciliação",
                    "local_audiencia": "Fórum Central",
                    "status_audiencia": "Agendada",
                    "link_audiencia": "https://microsoft.com..."
                }
            ]
        }
        return resposta # Retorna o dicionário para o factory_bot.py printar

    except Exception as e:
        raise Exception(f"Falha na automação e-SAJ: {str(e)}")
    finally:
        driver.quit()
