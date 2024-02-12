import requests
from decouple import config


class AuthApi:

    def __init__(self, insurance):
        self.insurance = insurance

    @property
    def url(self):
        return config('URL_{}_API'.format(self.insurance))

    @property
    def username(self):
        return config('USER_{}_API'.format(self.insurance))

    @property
    def password(self):
        return config('PASSWORD_{}_API'.format(self.insurance))

    def get_token(self):
        api_auth_url = 'http://{}/api-token-auth/'.format(self.url)
        result = requests.post(api_auth_url, json={
            "username": self.username, "password": self.password}).json()
        return result.get('token')
