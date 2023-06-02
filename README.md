# Hiring Challenge - Kanastra

O Projeto para o teste técnico da Kanastra disponibiliza uma API Pública para gerenciamento de débitos e seus pagamentos.


Recursos disponíveis para acesso via API:

* [**Débitos**](#reference/recursos/pagamentos)
* [**Webhooks**](#reference/recursos/webhooks)

## Métodos
Requisições para a API devem seguir os padrões:

| Método | Descrição |
|---|---|
| `GET` | Retorna informações de um ou mais registros. |
| `POST` | Utilizado para criar um novo registro. |
| `PUT` | Atualiza dados de um registro ou altera sua situação. |
| `DELETE` | Remove um registro do sistema. |


## Respostas

| Código | Descrição                                                                            |
|--------|--------------------------------------------------------------------------------------|
| `200`  | Requisição executada com sucesso (success).                                          |
| `201`  | Registro(a) criado com sucesso (success).                                            |
| `400`  | Erros de validação ou os campos informados não existem no sistema.                   |
| `404`  | Registro pesquisado não encontrado (Not found).                                      |
| `405`  | Método não implementado.                                                             |


# Autenticação

Por se tratar de uma API pública, a autenticação não se faz necessária.

# Recursos

# Débitos [/api/debits]
 Registro de débitos.

### Listar [GET /api/debits]
+ Request (application/json)

+ Response 200 (application/json)

          [{
            "debtId": "d0e77fab-05c0-4de5-ae31-ddc450b4d4fb",
            "debtExternalId": 7316,
            "customer": {
                "name": "John Doe",
                "governmentId": "11111111111",
                "email": "johndoe@kanastra.com.br"
            },
            "debtAmount": "1000000.00",
            "paidBy": "John Doe",
            "paidAmount": "100000.00",
            "paidAt": "2022-06-09 10:00:00",
            "debtDueDate": "2022-10-12 00:00:00",
            "charges": [
                {
                    "id": "e94c0572-c453-4703-b463-8a0a38fc6fec",
                    "debit_id": "d0e77fab-05c0-4de5-ae31-ddc450b4d4fb",
                    "amount": "1000000.00",
                    "barcode": "9781433500985",
                    "due_date": "2022-10-12 00:00:00",
                    "created_at": "2023-06-01T23:42:56.000000Z",
                    "updated_at": "2023-06-01T23:42:56.000000Z"
                }
            ]
          }]

### Novo (Create) [POST]

+ Request (application/json)

  + Headers

            Content-Type: application/json

  + Body

            {
              "debitsFile": "debits.csv"
            }

  + Response 201 (application/json)

      + Body

              [{
                    "debtId": "e94c0572-c453-4703-b463-8a0a38fc6fec",
                    "debtExternalId": 8307,
                    "customer": {
                    "name": "John Doe",
                    "governmentId": "11111111111",
                    "email": "johndoe@kanastra.com.br"
                    },
                    "debtAmount": "1000000.00",
                    "paidBy": null,
                    "paidAmount": "0.00",
                    "paidAt": null,
                    "debtDueDate": "2022-10-12 00:00:00",
                    "charges": []
              }]


### Detalhar [GET /debits/{debtId}]

+ Request (application/json)

+ Parameters
    + debtId (required, string, `e94c0572-c453-4703-b463-8a0a38fc6fec`) ... Código interno do débito

      + Response 200 (application/json)

          + Body

                  {
                    "data": {
                        "debtId": "d0e77fab-05c0-4de5-ae31-ddc450b4d4fb",
                        "debtExternalId": 7316,
                        "customer": {
                            "name": "John Doe",
                            "governmentId": "11111111111",
                            "email": "johndoe@kanastra.com.br"
                        },
                        "debtAmount": "1000000.00",
                        "paidBy": "John Doe",
                        "paidAmount": "100000.00",
                        "paidAt": "2022-06-09 10:00:00",
                        "debtDueDate": "2022-10-12 00:00:00",
                        "charges": [
                            {
                            "id": "e94c0572-c453-4703-b463-8a0a38fc6fec",
                            "debit_id": "d0e77fab-05c0-4de5-ae31-ddc450b4d4fb",
                            "amount": "1000000.00",
                            "barcode": "9781433500985",
                            "due_date": "2022-10-12 00:00:00",
                            "created_at": "2023-06-01T23:42:56.000000Z",
                            "updated_at": "2023-06-01T23:42:56.000000Z"
                            }
                        ]
                    }
                  }

### Excluír débito [DELETE /debits/{debtId}]

+ Request (application/json)

+ Parameters
    + debtId (required, string, `e94c0572-c453-4703-b463-8a0a38fc6fec`) ... Código interno do débito

+ Response 200 (application/json)

+ Body

        {"deleted"}

# Webhooks [/webhook]
O sistema está preparado para receber atualizações de pagamento diretamente feitas pelo banco. 

A documentação necessária para o envia da atualização pelo banco está documentada abaixo:

### Registro de pagamento [POST /webhook]

+ Request (application/json)


  + Headers

            Content-Type: application/json

  + Body

            {
                "debtId": "8291",
                "paidAt": "2022-06-09 10:00:00",
                "paidAmount": 100000.00,
                "paidBy": "John Doe"
            }

+ Response 200 (application/json)


+ Body

      {
        "data": {
        "debtId": "153e1b0b-18e9-42c6-85e9-b7be0fe8cf5c",
        "debtExternalId": 8291,
        "customer": {
            "name": "John Doe",
            "governmentId": "11111111111",
            "email": "johndoe@kanastra.com.br"
        },
        "debtAmount": "100.00",
        "paidBy": "John Doe",
        "paidAmount": "100000.00",
        "paidAt": "2022-06-09 10:00:00",
        "debtDueDate": "2022-10-12 00:00:00",
        "charges": []
        }
      }
