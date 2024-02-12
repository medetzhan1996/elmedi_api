from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated
from rest_framework.generics import CreateAPIView, UpdateAPIView, RetrieveAPIView, DestroyAPIView

from .serializers import CustomerSerializer, CustomerInsuranceSerializer
from ..models import Customer, CustomerInsurance


# Mixin клиента
class CustomerMixin:
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    serializer_class = CustomerSerializer
    queryset = Customer.objects.all()
    lookup_field = 'iin'


# Создать нового клиента
class CustomerCreateView(CustomerMixin, CreateAPIView):
    pass


# Обновить клиента
class CustomerUpdateView(CustomerMixin, UpdateAPIView):
    pass


# Детальная информация клиента
class CustomerDetailView(CustomerMixin, RetrieveAPIView):
    pass


# Удалить страховку клиента
class CustomerDestroyView(CustomerMixin, DestroyAPIView):
    pass

    def perform_destroy(self, instance):
        insurance = self.request.user.insurance
        customer_insurance = CustomerInsurance.objects.filter(customer=instance)
        customer_insurance.filter(insurance=insurance).delete()
        if not customer_insurance.exists():
            instance.delete()


# Mixin страховки клиента
class CustomerInsuranceMixin:
    serializer_class = CustomerInsuranceSerializer
    queryset = CustomerInsurance.objects.all()
    lookup_field = 'card_number'


# Создать новую страховку клиента
class CustomerInsuranceCreateView(CustomerInsuranceMixin, CreateAPIView):
    pass


# Обновить страховку клиента
class CustomerInsuranceUpdateView(CustomerInsuranceMixin, UpdateAPIView):
    pass


# Детальная информация страховки клиента
class CustomerInsuranceDetailView(CustomerInsuranceMixin, RetrieveAPIView):
    pass


# Удалить страховку клиента
class CustomerInsuranceDestroyView(CustomerInsuranceMixin, DestroyAPIView):
    pass