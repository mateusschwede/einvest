# einvest
Software auxiliar de recomendações de compra de ações em investimentos

## Questões:
- Analista ñ pd excluir, nem editar ação existente em carteira de ações


### Criar carteira:

Tela 1:
- Informa nome
- Informa precoInvestimento
(Cancelar - Confirmar)
Confirmar: Cria carteira ($_SESSION[idCarteira]) (Verificar se há ações cadastradas no sistema)

Tela 2:
- addAcao e percentual
- Listar ações e percentual (edPercentual - remAcaoCarteira)
(Cancelar(delete) - Finalizar)

Finalizar: SUM(percentuais)=100


## Bugs e Fazer:
- Erro ao calcular o precoPercentual por ação em carteira de ações (cliente/index.php)