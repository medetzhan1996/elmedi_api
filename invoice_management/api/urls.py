from django.urls import path
from . import views

app_name = 'invoice_api'

urlpatterns = [
    path('invoice/create', views.InvoiceCreateView.as_view(), name='invoice-create'),
    path('<int:pk>', views.InvoiceDetail.as_view(), name='invoice-detail'),
    path('invoices/<str:iin>/by_iin', views.InvoicesByIin.as_view(), name='invoices_by_iin'),
    path('invoices/<str:iin>/by_iin/<str:hospital_code>/by_hospital',
        views.InvoicesByHospital.as_view(), name='invoices_by_hospital'),
    path('performed/services', views.PerformedServicesView.as_view(),
         name='performed_services'),
]
