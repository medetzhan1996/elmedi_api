"""elmedi_api URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/4.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path, include
from django.contrib.auth import views as auth_views
from rest_framework.authtoken import views
from account.views import RegisterView

urlpatterns = [
    path('admin/', admin.site.urls),
    path('login/', auth_views.LoginView.as_view(template_name='account/login.html'), name='login'),
    path('logout/', auth_views.LogoutView.as_view(), name='logout'),
    path('account/', include('account.urls', namespace='account')),
    path('register/', RegisterView.as_view(), name='register'),
    path('/', include('customer_personal_cabinet.urls', namespace='customer_personal_cabinet')),
    path('import_data/', include('import_data.urls', namespace='import_data')),
    path('api/directory/', include('directory.api.urls', namespace='directory_api')),
    path('report_management/', include('report_management.urls', namespace='report_management')),
    
    path('api/customer_management/', include('customer_management.api.urls', namespace='customer_management_api')),
    path('api/document_management/', include('document_management.api.urls', namespace='document_management')),
    path('api/referral_management/', include('referral_management.api.urls', namespace='referral_management_api')),
    path('api/invoice_management/', include('invoice_management.api.urls', namespace='invoice_management_api')),
    path('api/google_extension/', include('google_extension.api.urls', namespace='google_extension_api')),
    path('api-token-auth/', views.obtain_auth_token),
    path('api/customer_personal_cabinet/', include('customer_personal_cabinet.api.urls',
        namespace='customer_personal_cabinet_api')),
]
