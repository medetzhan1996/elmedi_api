from rest_framework.generics import CreateAPIView, RetrieveUpdateDestroyAPIView, ListAPIView
from rest_framework.exceptions import ValidationError
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated
from rest_framework.views import APIView
from rest_framework.response import Response
from .serializers import InvoiceSerializer, PerformedServicesSerializer
from ..models import Invoice
from .services import create_invoice, get_services
from customer_management.models import CustomerInsurance


# Mixin счет реестра
class InvoiceMixin:
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    queryset = Invoice.objects.all()
    serializer_class = InvoiceSerializer


# Список счет реесторов по ИИН
class InvoicesByIin(InvoiceMixin, ListAPIView):

    def get_queryset(self):
        queryset = self.queryset.filter(customer__iin=self.kwargs['iin'])
        return queryset


# Список счет реесторов по ИИН
class InvoicesByHospital(InvoiceMixin, ListAPIView):

    def get_queryset(self):
        queryset = self.queryset.filter(
            customer__iin=self.kwargs['iin']).exclude(
            hospital__code=self.kwargs['hospital_code'])
        return queryset


# Создать счет реестр
class InvoiceCreateView(InvoiceMixin, CreateAPIView):
    name = 'invoice-create'

    def perform_create(self, serializer):
        try:
            card_number = self.request.data.get('customer_insurance')
            customer_insurance = CustomerInsurance.objects.get(card_number=card_number)
            insurance_code = customer_insurance.insurance.code
            result = create_invoice(insurance_code, self.request.data)
            if result.status_code == 201:
                serializer.save()
            else:
                raise ValidationError(result.json())
        except CustomerInsurance.DoesNotExist:
            return Response({'Клиент с указанной картой, не найден!'})


# Посмотреть детальную информацию счет реестра
class InvoiceDetail(InvoiceMixin, RetrieveUpdateDestroyAPIView):
    name = 'invoice-detail'


# Список выполняемых услуг
class PerformedServicesView(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)

    def post(self, request):
        results = PerformedServicesSerializer(data=request.data)
        if results.is_valid(raise_exception=True):
            card_number = request.data.get('card_number')
            hospital = request.data.get('hospital')
            try:
                customer = CustomerInsurance.objects.get(card_number=card_number)
                insurance = customer.insurance
                performed_services = get_services(insurance.code, request.data, hospital)
                return Response(performed_services)
            except CustomerInsurance.DoesNotExist:
                return Response({'Клиент с указанной картой, не найден!'})
        return Response({})
