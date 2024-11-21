import requests
from decouple import config
from requests.adapters import HTTPAdapter
from requests.packages.urllib3.util.retry import Retry


def get_available_hospitals(insurance, card_number):
    url_api = config('URL_{}_API'.format(insurance))
    token_api = config('TOKEN_{}_API'.format(insurance))
    url_available_hospitals_api = 'http://{}/api/contract_management/{}/available/hospitals'.format(
        url_api, card_number)
    retry_strategy = Retry(
        total=10,  # Increased number of retries
        status_forcelist=[429, 500, 502, 503, 504],
        backoff_factor=1
    )
    adapter = HTTPAdapter(max_retries=retry_strategy)    

    with requests.Session() as session:
        session.mount("http://", adapter)
        session.mount("https://", adapter)
        try:
            result = session.get(url_available_hospitals_api, headers={'Authorization': 'Token ' + token_api}, timeout=5).json()  # Increased timeout to 5 seconds
            return result
        except (ConnectionError, requests.exceptions.Timeout) as e:
            print("Error:", e)
            return None  # Return None to indicate that the request failed


def get_services(insurance_code, card_number, hospital, type_appeal='2'):
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    data = {
        'card_number': card_number,
        'hospital': hospital,
        'type_appeal': type_appeal,
        'place': '3',
        'icd': 'T88.7'
    }
    url_performed_services_api = 'http://{}/api/contract_management/performed/services'.format(url_api)

    retry_strategy = Retry(
        total=5,
        status_forcelist=[429, 500, 502, 503, 504],
        backoff_factor=1
    )
    adapter = HTTPAdapter(max_retries=retry_strategy)

    with requests.Session() as session:
        session.mount("http://", adapter)
        session.mount("https://", adapter)
        try:
            result = session.post(url_performed_services_api, data=data, headers={'Authorization': 'Token ' + token_api}, timeout=1).json()
            return result
        except (ConnectionError, requests.exceptions.Timeout) as e:
            print("Error:", e)
            return []


def get_programs(insurance_code):
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    print('token ............................', token_api)
    url = 'http://{}/api/contract_management/program/list'.format(
        url_api)
    retry_strategy = Retry(
        total=5,
        status_forcelist=[429, 500, 502, 503, 504],
        backoff_factor=1
    )
    adapter = HTTPAdapter(max_retries=retry_strategy)    

    with requests.Session() as session:
        session.mount("http://", adapter)
        try:
            result = session.get(url, headers={'Authorization': 'Token ' + token_api}, timeout=10)
            return result
        except (ConnectionError, requests.exceptions.Timeout) as e:
            print("Error:", e)
            return


def get_contract_customer(insurance_code, card_number):
    url_api = config('URL_{}_API'.format(insurance_code))
    token_api = config('TOKEN_{}_API'.format(insurance_code))
    url = 'http://{}/api/contract_management/contract_customer/{}/detail'.format(url_api, card_number)

    retry_strategy = Retry(
        total=5,
        status_forcelist=[429, 500, 502, 503, 504],
        backoff_factor=1
    )
    adapter = HTTPAdapter(max_retries=retry_strategy)    

    with requests.Session() as session:
        session.mount("http://", adapter)
        try:
            result = session.get(url, headers={'Authorization': 'Token ' + token_api}, timeout=1).json()
            return result
        except (ConnectionError, requests.exceptions.Timeout) as e:
            print("Error:", e)
            return


