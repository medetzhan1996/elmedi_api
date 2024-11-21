import requests
from decouple import config


def get_customer(insurance, iin):
    url_api = config('URL_{}_API'.format(insurance))
    token_api = config('TOKEN_{}_API'.format(insurance))
    url_available_hospitals_api = 'http://127.0.0.1:8000/api/customer/customer/{}/retrieve'.format(
        url_api, iin)
    try:
        result = requests.get(url_available_hospitals_api,
                              headers={'Authorization': 'Token ' + token_api}, timeout=1).json()
        return result
    except ConnectionError:
        return []

def create_customer(insurance_code, data):
    result = []
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    url_invoice_api = 'http://{}/api/customer/customer/create'.format(url_api)
    json_data = {
        'first_name': data.get('first_name'),
        'last_name': data.get('last_name'),
        'iin': data.get('iin')
    }
    result = requests.post(url_invoice_api, data=json_data, headers={'Authorization': 'Token ' + token_api})
    return result.json()


def get_customer_insurances(insurance_code, iin):
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    url_customer_insurance_api = 'http://{}/api/contract_management/customer/{}/contract/list'.format(
        url_api, iin)
    try:
        result = requests.get(url_customer_insurance_api,
                              headers={'Authorization': 'Token ' + token_api}, timeout=1).json()
        return result
    except ConnectionError:
        return []


def create_contract_customer(insurance_code, data):
    result = []
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    url_invoice_api = 'http://{}/api/contract_management/contract/customer/create'.format(url_api)
    json_data = {
        'contract': data.get('contract'),
        'customer': data.get('customer'),
        'number': data.get('number'),
        'begin_date': data.get('begin_date'),
        'end_date': data.get('end_date'),
        'type_holder': data.get('type_holder'),
        'program': data.get('program'),
    }
    result = requests.post(url_invoice_api, data=json_data, headers={'Authorization': 'Token ' + token_api})
    return result.json()