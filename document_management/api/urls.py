from django.urls import path
from . import views

app_name = 'document_management_api'

urlpatterns = [
    path('<str:iin>/attached/document/create/template',
         views.AttachedDocumentCreateTemplate.as_view(), name='attached_document_create'),
    path('<str:iin>/attached/document/list/template',
         views.AttachedDocumentListTemplate.as_view(), name='attached_document_list'),
    path('attached/document/', views.AttachedDocumentList.as_view(), name='attached-document-list'),

    path('attached/document/create', views.AttachedDocumentCreateView.as_view(), name='attached-document-create'),
    path('attached/document/<int:pk>', views.AttachedDocumentDetail.as_view(), name='invoice-detail'),
    path('attached/document/<str:iin>/by_iin', views.AttachedDocumentByIin.as_view(), name='invoices_by_iin'),
]
