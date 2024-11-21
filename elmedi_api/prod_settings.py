import os
from pathlib import Path
BASE_DIR = Path(__file__).resolve(strict=True).parent.parent

SECRET_KEY = '*+uiasgfhfhea(0_=n@c6aacvxcd*xtaassdkjlgvzo'

DEBUG = True

ALLOWED_HOSTS = ['82.200.165.222', '192.168.96.203']

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.postgresql_psycopg2',
        'NAME': 'elmedi_api_db',
        'USER': 'medet',
        'PASSWORD': 'dostar1996',
        'HOST': 'localhost',
        'PORT': '5432'
    },
    'db_03': {
        'ENGINE': 'django.db.backends.postgresql_psycopg2',
        'NAME': 'postgres',
        'USER': 'prod01',
        'PASSWORD': '5B%vOz8f',
        'HOST': '10.0.100.3',
        'PORT': '5432'
    },
    'db_8037': {
        'ENGINE': 'django.db.backends.postgresql_psycopg2',
        'NAME': 'elmedi_db',
        'USER': 'medet',
        'PASSWORD': 'dostar1996',
        'HOST': '192.168.100.37',
        'PORT': '5432'
    }
}

STATIC_ROOT = os.path.join(BASE_DIR, 'static')
CSRF_TRUSTED_ORIGINS = ['http://82.200.165.222:19603', 'https://portal.euromedix.org']
