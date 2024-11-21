from django.urls import path
from . import views

app_name = 'customer_management_api'

urlpatterns = [
    path('customer/create', views.CustomerCreateView.as_view(),
         name='customer_create'),
    path('customer/<str:iin>/update', views.CustomerUpdateView.as_view(),
         name='customer_update'),
    path('customer/<str:iin>/detail', views.CustomerDetailView.as_view(),
         name='customer_detail'),
    path('customer/<str:iin>/destroy', views.CustomerDestroyView.as_view(),
         name='customer_destroy'),

    path('customer_insurance/create', views.CustomerInsuranceCreateView.as_view(),
         name='customer_insurance_create'),
    path('customer_insurance/<str:card_number>/update', views.CustomerInsuranceUpdateView.as_view(),
         name='customer_insurance_update'),
    path('customer_insurance/<str:card_number>/detail', views.CustomerInsuranceDetailView.as_view(),
         name='customer_insurance_detail'),
    path('customer_insurance/<str:card_number>/destroy', views.CustomerInsuranceDestroyView.as_view(),
         name='customer_insurance_destroy'),
]
