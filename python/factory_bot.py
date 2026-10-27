import sys
import json

# Importa os módulos dos robôs específicos que estão dentro da pasta 'bots'
# À medida que criar novos robôs (como bot_pje.py), adicione a importação aqui.

try:
    from bots.bot_esaj import rodar_esaj
    # from bots.bot_pje import rodar_pje  <-- Exemplo de futuros robôs

except ImportError as e:
    sys.stderr.write(f"Erro ao importar módulos de robôs: {str(e)}\n")
    sys.exit(1)

def main():
    # 1. Validação de segurança dos argumentos vindos do Laravel
    # sys.argv[0] é o nome do próprio script. Os parâmetros começam no índice 1.
    if len(sys.argv) < 4:
        sys.stderr.write("Erro: Parâmetros insuficientes. Esperado: credenciais, sistema, numero_processo.\n")
        sys.exit(1)

    try:
        # 2. Captura e decodificação dos parâmetros
        credenciais_json = sys.argv[1]
        sistema = sys.argv[2].lower().strip()      # ex: 'esaj', 'pje', 'eproc'
        numero_processo = sys.argv[3].strip()

        credenciais = json.loads(credenciais_json)
        usuario = credenciais.get('usuario')
        senha = credenciais.get('senha')

        if not usuario or not senha:
            raise ValueError("Credenciais de usuário ou senha estão vazias.")

        # 3. O CORAÇÃO DO PATRÃO FACTORY: Direcionamento dinâmico
        dados_finais = None

        if sistema == 'esaj':
            # Executa a função mapeada no arquivo 'bots/bot_esaj.py'
            dados_finais = rodar_esaj(usuario, senha, numero_processo)

        elif sistema == 'pje':
            # dados_finais = rodar_pje(usuario, senha, numero_processo)
            raise NotImplementedError("O robô para o sistema PJe ainda está em desenvolvimento.")

        else:
            raise ValueError(f"O sistema jurídico '{sistema}' não é suportado por este orquestrador.")

        # 4. Retorno Absoluto: Printa APENAS o JSON final na tela para o Laravel capturar
        if dados_finais:
            print(json.dumps(dados_finais, ensure_ascii=False))
        else:
            raise Exception("O robô terminou a execução sem retornar dados válidos.")

    except json.JSONDecodeError:
        sys.stderr.write("Erro crítico: As credenciais enviadas pelo Laravel não são um JSON válido.\n")
        sys.exit(1)
    except Exception as e:
        sys.stderr.write(f"Erro na execução da automação ({sys.argv[2]}): {str(e)}\n")
        sys.exit(1)

if __name__ == "__main__":
    main()
