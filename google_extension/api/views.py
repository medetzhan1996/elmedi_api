from rest_framework import generics
from django_filters.rest_framework import DjangoFilterBackend
from rest_framework import status
from rest_framework.views import APIView
from django.http import JsonResponse
from rest_framework.response import Response
from rest_framework.renderers import JSONRenderer, TemplateHTMLRenderer
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated
from .serializers import ReferralSerializer, HospitalServicesSerializer
from referral_management.models import Referral
from referral_management.forms import ReferralForm, ReferralPerformForm
from directory.models import Hospital
from invoice_management.forms import InvoiceForm


class ReferralListByCustomerTemplateView(APIView):
    authentication_classes = (TokenAuthentication, )
    permission_classes = (IsAuthenticated, )
    renderer_classes = [TemplateHTMLRenderer]
    template_name = 'google_extension/api/list_by_customer.html'

    def get(self, request, *args, **kwargs):
        search = self.kwargs['search']
        referrals = Referral.objects.filter(customer__iin=search).all()
        print(referrals)
        print('tets.....')
        print(search)
        return Response({'referrals': referrals})


# Посмотреть список или создать направление
class ReferralCreateByCustomerTemplateView(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated, )
    renderer_classes = [TemplateHTMLRenderer]

    def get(self, request, *args, **kwargs):
        iin = self.kwargs['iin']
        form = ReferralForm(iin=iin)
        return Response(
            {'form': form}, template_name='google_extension/api/create_by_customer.html')

    def post(self, request, *args, **kwargs):
        iin = self.kwargs['iin']
        hospital = request.user.hospital
        form = ReferralForm(iin=iin, hospital=hospital, data=request.POST)
        if form.is_valid():
            form.save()
            return JsonResponse({'status': 'success'})
        return JsonResponse({'status': 'error', 'error': form.errors.as_json()})


class ReferralPerformTemplateView(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated, )
    renderer_classes = [TemplateHTMLRenderer]

    def get(self, request, *args, **kwargs):
        pk = self.kwargs['pk']
        referral = Referral.objects.get(pk=pk)
        form = ReferralPerformForm(instance=referral)
        return Response(
            {'referral': referral, 'form': form},
            template_name='google_extension/api/perform.html')

    def post(self, request, *args, **kwargs):
        pk = self.kwargs['pk']
        referral = Referral.objects.get(pk=pk)
        form = ReferralPerformForm(request.POST, instance=referral)
        if form.is_valid():
            form.save()
            invoice_form = InvoiceForm({
                'service': referral.service,
                'icd': referral.icd,
                'contract_customer': referral.customer_insurance.card_number,
                'referral': referral,
                'hospital': request.user.hospital,
                'consumption': 20,
                'performing_doctor': request.POST.get('performing_doctor')
            })
            if invoice_form.is_valid():
                invoice_form.save()
            return JsonResponse({'status': 'success'})
        return JsonResponse({'status': 'error'})


# Посмотреть детальную информацию направления
class ReferralListView(generics.ListCreateAPIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated, )
    serializer_class = ReferralSerializer
    queryset = Referral.objects.all()
    name = 'referral-list'
    filter_backends = [DjangoFilterBackend]
    filterset_fields = ['customer']


# Посмотреть детальную информацию направления
class ReferralDetailView(generics.RetrieveUpdateDestroyAPIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated, )
    queryset = Referral.objects.all()
    serializer_class = ReferralSerializer
    name = 'referral-detail'


# Посмотреть детальную информацию направления
class HospitalServicesListView(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated, )

    def post(self, request):
        serialized = HospitalServicesSerializer(
            data=request.data)
        if serialized.is_valid():
            services = request.data.get('services')
            hospitals = Hospital.get_hospitals_by_services(services)
            return Response(hospitals,
                            status=status.HTTP_201_CREATED)
        return Response(serialized._errors,
                        status=status.HTTP_400_BAD_REQUEST)


class IndexView(APIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated, )
    renderer_classes = [TemplateHTMLRenderer]
    template_name = 'google_extension/api/index.html'

    def get(self, request):
        return Response({'profiles': 'test'})