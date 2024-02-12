import base64
from rest_framework import generics
from rest_framework.generics import CreateAPIView, RetrieveUpdateDestroyAPIView, ListAPIView
from rest_framework.exceptions import ValidationError
from rest_framework.views import APIView
from rest_framework.response import Response
from django.http import JsonResponse
from rest_framework.renderers import TemplateHTMLRenderer
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated

from customer_management.models import Customer
from .serializers import AttachedDocumentSerializer
from .services import create_attached_document
from ..models import AttachedDocument
from ..forms import AttachedDocumentForm


# Посмотреть список или создать направление
class AttachedDocumentCreateTemplate(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    renderer_classes = [TemplateHTMLRenderer]
    template_name = 'document_management/api/attached_document/form.html'

    def get(self, request, *args, **kwargs):
        iin = kwargs.get('iin')
        form = AttachedDocumentForm()
        return Response({'form': form, 'iin': iin})

    def post(self, request, *args, **kwargs):
        iin = kwargs.get('iin')
        customer = Customer.objects.get(iin=iin)
        form = AttachedDocumentForm(data=request.POST, files=request.FILES)
        if form.is_valid():
            obj = form.save(commit=False)
            obj.customer = customer
            obj.save()
            return JsonResponse({'status': 'success'})
        return JsonResponse({'status': 'error'})


# Посмотреть список или создать направление
class AttachedDocumentListTemplate(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    renderer_classes = [TemplateHTMLRenderer]
    template_name = 'document_management/api/attached_document/list.html'

    def get(self, request, *args, **kwargs):
        iin = kwargs.get('iin')
        attached_documents = AttachedDocument.objects.filter(customer__iin=iin).all()
        return Response({'attached_documents': attached_documents})


# Посмотреть детальную информацию направления
class AttachedDocumentList(generics.ListCreateAPIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated, )
    serializer_class = AttachedDocumentSerializer
    queryset = AttachedDocument.objects.all()
    name = 'attached-document-list'


# Mixin счет реестра
class AttachedDocumentMixin:
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    queryset = AttachedDocument.objects.all()
    serializer_class = AttachedDocumentSerializer


# Список счет реесторов по ИИН
class AttachedDocumentByIin(AttachedDocumentMixin, ListAPIView):

    def get_queryset(self):
        queryset = self.queryset.filter(customer__iin=self.kwargs['iin'])
        return queryset


# Создать счет реестр
class AttachedDocumentCreateView(AttachedDocumentMixin, CreateAPIView):
    name = 'attached-document-create'

    def perform_create(self, serializer):
        insurance_code = self.request.user.insurance.code
        print(self.request.data)
        result = create_attached_document(insurance_code, self.request.data)
        if result.status_code == 201:
            serializer.save()
        else:
            raise ValidationError(result.json())


# Посмотреть детальную информацию счет реестра
class AttachedDocumentDetail(AttachedDocumentMixin, RetrieveUpdateDestroyAPIView):
    name = 'attached-document-detail'
