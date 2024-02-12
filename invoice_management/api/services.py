import requests
from decouple import config


def create_invoice(insurance_code, data):
    result = []
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    url_invoice_api = 'http://{}/api/invoice_management/invoice/create'.format(url_api)
    json_data = {
        'customer': data.get('customer'),
        'hospital': data.get('hospital'),
        'contract_customer': data.get('customer_insurance'),
        'icd': data.get('icd'),
        'type_appeal': data.get('type_appeal'),
        'place': data.get('place'),
        'service': data.get('service'),
        'doctor_signature': data.get('doctor_signature', None),
        'screen': data.get('screen', None),
    }
    result = requests.post(url_invoice_api, data=json_data, headers={'Authorization': 'Token ' + token_api})
    return result


def get_available_hospitals(insurance, card_number):
    url_api = config('URL_{}_API'.format(insurance))
    token_api = config('TOKEN_{}_API'.format(insurance))
    url_available_hospitals_api = 'http://{}/api/contract_management/{}/available/hospitals'.format(
        url_api, card_number)
    try:
        result = requests.get(url_available_hospitals_api,
                              headers={'Authorization': 'Token ' + token_api}, timeout=1).json()
        return result
    except ConnectionError:
        return []


def get_services(insurance_code, data, hospital):
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    card_number = data.get('card_number')
    type_appeal = data.get('type_appeal')
    place = data.get('place')
    icd = data.get('icd')
    data = {
        'card_number': card_number,
        'hospital': hospital,
        'icd': icd,
        'type_appeal': type_appeal,
        'place': place
    }
    url_performed_services_api = 'http://{}/api/contract_management/performed/services'.format(url_api)
    try:
        result = requests.post(url_performed_services_api, data=data,
                               headers={'Authorization': 'Token ' + token_api}, timeout=1).json()
        return result
    except ConnectionError:
        return []