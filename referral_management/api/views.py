from rest_framework.generics import CreateAPIView, RetrieveUpdateDestroyAPIView, ListAPIView, UpdateAPIView
from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated
from rest_framework.exceptions import ValidationError
from .serializers import ReferralSerializer
from rest_framework import filters
from customer_management.models import CustomerInsurance
from .services import create_referral
from ..models import Referral


class ReferralMixin:
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    queryset = Referral.objects.all()
    serializer_class = ReferralSerializer


# Посмотреть список направлении
class ReferralCreate(ReferralMixin, CreateAPIView):
    name = 'referral-create'

    def perform_create(self, serializer):
        card_number = self.request.data.get('customer_insurance')
        customer_insurance = CustomerInsurance.objects.get(card_number=card_number)
        insurance_code = customer_insurance.insurance.code
        result = create_referral(insurance_code, self.request.data)
        if result.status_code == 201:
            serializer.save()
        else:
            raise ValidationError(result.json())


# Посмотреть детальную информацию направления
class ReferralDetail(ReferralMixin, RetrieveUpdateDestroyAPIView):
    name = 'referral-detail'


class ReferralList(ReferralMixin, ListAPIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    search_fields = ['title', 'code']
    filter_backends = (filters.SearchFilter,)


# Список счет реесторов по ИИН
class ReferralsByHospital(ReferralMixin, ListAPIView):

    def get_queryset(self):
        queryset = self.queryset.filter(
            directed_hospital__code=self.kwargs['hospital_code'],
            is_saved=False)
        return queryset


class ReferralsByIin(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)

    def get(self, request, *args, **kwargs):
        iin = self.kwargs['iin']
        query = Referral.objects.filter(customer__iin=iin).all()
        serializer = ReferralSerializer(query, many=True)
        return Response(serializer.data)


class ReferralUpdateView(UpdateAPIView):
    authentication_classes = (TokenAuthentication,)
    queryset = Referral.objects.all()
    serializer_class = ReferralSerializer

    def post(self, request, *args, **kwargs):
        instance = self.get_object()
        instance.is_saved = True  # изменяем значение поля is_saved на True
        instance.save()
        serializer = self.get_serializer(instance, data=request.data, partial=True)
        serializer.is_valid(raise_exception=True)
        return Response(serializer.data)