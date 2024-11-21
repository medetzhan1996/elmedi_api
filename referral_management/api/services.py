import requests
from decouple import config

# Добавить направления
def create_referral(insurance_code, data):
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    url_referral_api = 'http://{}/api/referral_management/referral/create'.format(url_api)
    data = {
        'customer': data.get('customer'),
        'sending_hospital': data.get('sending_hospital'),
        'directed_hospital': data.get('directed_hospital'),
        'contract_customer': data.get('customer_insurance'),
        'icd': data.get('icd'),
        'type_appeal': data.get('type_appeal'),
        'place': data.get('place'),
        'service': data.get('service'),
        'date': data.get('date'),
    }
    result = requests.post(url_referral_api, data=data, headers={'Authorization': 'Token ' + token_api})
    return result