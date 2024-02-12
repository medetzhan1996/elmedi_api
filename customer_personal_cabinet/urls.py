from django.urls import path
from . import views
app_name = 'customer_personal_cabinet'

urlpatterns = [
    path('index/', views.IndexView.as_view(), name='index'),
    path('index/<str:card_number>/hospital/<str:hospital>/service/<str:service>/',
         views.IndexView.as_view(), name='index'),
    path('insurance/list', views.InsuranceListView.as_view(), name='insurance_list'),
    path('hospital/list', views.HospitalListView.as_view(), name='hospital_list'),
    path('<str:card_number>/hospital/<str:hospital_code>/service/list', views.HospitalServiceListView.as_view(),
         name='hospital_service_list'),
    path('appointment_method/<str:hospital>/service/<str:service>/<str:card_number>/list', views.AppointmentMethodListView.as_view(),
         name='appointment_method'),
    path('doctor/list/', views.DoctorListView.as_view(), name='doctor_list'),
    path('<str:card_number>/<str:hospital_code>/doctor/list/', views.DoctorListView.as_view(), name='doctor_list'),
    path('<str:card_number>/<str:hospital_code>/doctor/list/<str:service_code>',
         views.DoctorListView.as_view(), name='doctor_list'),
    path('doctor/<int:doctor>/appointment/list/', views.DoctorAppointmentListView.as_view(),
         name='doctor_appointment'),
    path('doctor/appointment/create/', views.DoctorAppointmentCreateView.as_view(),
         name='doctor_appointment_create'),
    path('attached_document/', views.AttachedDocumentView.as_view(), name='attached_document'),
    path('attached_document/<int:pk>/detail', views.AttachedDocumentDetailView.as_view(),
     name='attached_document_detail'),
    path('services/', views.ServicesView.as_view(), name='services'),
    path('signatures/', views.SignaturesView.as_view(), name='signatures'),
    path('pay_program/list/', views.PayProgramListView.as_view(), name='pay_program_list'),
    path('pay_program/<int:pk>/contract/', views.PayProgramContractView.as_view(), name='pay_program_contract_list'),
    
]
