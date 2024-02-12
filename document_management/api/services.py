import requests
from decouple import config


def create_attached_document(insurance_code, data):
    result = []
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    url_invoice_api = 'http://{}/api/document_management/attached/document/'.format(url_api)
    json_data = {
        'title': data.get('title', None),
        'customer': data.get('customer'),
        'file': data.get('file', None),
        'screen': data.get('screen', None),
        'invoice': data.get('invoice', None)
    }
    result = requests.post(url_invoice_api, data=json_data, headers={'Authorization': 'Token ' + token_api})
    return result