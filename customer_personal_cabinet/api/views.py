import os
import json
import requests
from rest_framework import status
from dotenv import load_dotenv

from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated
from rest_framework.decorators import authentication_classes, permission_classes
from rest_framework.generics import CreateAPIView, UpdateAPIView,\
    RetrieveAPIView, DestroyAPIView, RetrieveUpdateDestroyAPIView, ListAPIView
from .services import get_services
from .serializers import PerformedServicesSerializer, DoctorTimetableSerializer, DoctorSerializer
from customer_management.models import CustomerInsurance
from customer_personal_cabinet.models import DoctorTimetable, Doctor


# Список выполняемых услуг
class PerformedServicesView(APIView):

    def post(self, request):
        results = PerformedServicesSerializer(data=request.data)
        if results.is_valid(raise_exception=True):
            card_number = request.data.get('card_number')
            try:
                customer = CustomerInsurance.objects.get(card_number=card_number)
                insurance = customer.insurance
                performed_services = get_services(insurance.code, request.data)
                return Response(performed_services)
            except CustomerInsurance.DoesNotExist:
                return Response({'Клиент с указанной картой, не найден!'})
        return Response({})


# Mixin счет реестра
class DoctorMixin:
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    queryset = Doctor.objects.all()
    serializer_class = DoctorSerializer


# Список счет реесторов по ИИН
class DoctorByHospital(DoctorMixin, ListAPIView):

    def get_queryset(self):
        queryset = self.queryset.filter(hospital__code=self.kwargs['code'])
        return queryset


# Mixin графика работы доктора
class DoctorTimetableMixin:
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    queryset = DoctorTimetable.objects.all()
    serializer_class = DoctorTimetableSerializer


# Создать счет реестр
class DoctorTimetableCreateView(DoctorTimetableMixin, CreateAPIView):
    name = 'doctor-timetable-create'


# Посмотреть детальную информацию счет реестра
class DoctorTimetableDetail(DoctorTimetableMixin, RetrieveUpdateDestroyAPIView):
    name = 'doctor-timetable-detail'


load_dotenv()

HOSPITALS_TOKENS = {
    "hospital1": os.environ.get("HOSPITAL1_TOKEN")
}
INSURANCES_TOKENS = {
    "insurance1": os.environ.get("INSURANCE1_TOKEN")
}
with open("config.json", "r") as f:
    CONFIG = json.load(f)

HOSPITALS_TO_SERVERS = CONFIG["HOSPITALS_TO_SERVERS"]
INSURANCES_TO_SERVERS = CONFIG["INSURANCES_TO_SERVERS"]


class AggregateFreeSlotsView(APIView):

    def get(self, request):
        specializations = request.query_params.getlist('specialization')
        start_date_str = request.query_params.get('start_date')
        end_date_str = request.query_params.get('end_date')
        requested_hospitals = request.query_params.getlist('hospitals')
        params = {
            'specialization': specializations,
            'start_date': start_date_str,
            'end_date': end_date_str
        }

        results = []

        servers_to_query = {hospital: HOSPITALS_TO_SERVERS[hospital] for hospital in requested_hospitals if
                            hospital in HOSPITALS_TO_SERVERS}

        for hospital, server in servers_to_query.items():
            headers = {'Authorization': f'Token {HOSPITALS_TOKENS[hospital]}'}
            response = requests.get(f"{server}api/register/free_slots/", params=params, headers=headers)
            # response = requests.get(f"{server}api/register/free_slots/", params=params)
            print("======================================")
            if response.status_code == 200:
                results.append(response.json())
                # results.extend(response.json().get('data', []))  # Предположим, что ответ возвращает список данных в ключе "data".
            else:
                pass



        return Response(results, status=status.HTTP_200_OK)


@authentication_classes([TokenAuthentication])
@permission_classes([IsAuthenticated])
class CustomerProfessionalExaminationView(APIView):

    def get(self, request):
        iin = request.query_params.get('iin')
        requested_insurances = request.query_params.getlist('insurance')
        results = []

        servers_to_query = {insurance: INSURANCES_TO_SERVERS[insurance] for insurance in requested_insurances if
                            insurance in INSURANCES_TO_SERVERS}
        for insurance, server in servers_to_query.items():
            headers = {'Authorization': f'Token {INSURANCES_TOKENS[insurance]}'}
            response = requests.get(f"{server}api/promedicine/professional/examination/{iin}", headers=headers)
            # response = requests.get(f"{server}api/register/free_slots/", params=params)
            print(response.text)
            if response.status_code == 200:
                results.append(response.json())
                # results.extend(response.json().get('data', []))  # Предположим, что ответ возвращает список данных в ключе "data".
            else:
                pass

        return Response(results, status=status.HTTP_200_OK)


class CustomerExaminationAppointmentView(APIView):

    def get(self, request):
        iin = request.query_params.get('iin')
        requested_insurances = request.query_params.getlist('insurance')
        results = []

        servers_to_query = {insurance: INSURANCES_TO_SERVERS[insurance] for insurance in requested_insurances if
                            insurance in INSURANCES_TO_SERVERS}
        for insurance, server in servers_to_query.items():
            headers = {'Authorization': f'Token {INSURANCES_TOKENS[insurance]}'}
            response = requests.get(f"{server}api/promedicine/examination/appointments/{iin}", headers=headers)
            if response.status_code == 200:
                results.append(response.json())
            else:
                pass

        return Response(results, status=status.HTTP_200_OK)


@authentication_classes([TokenAuthentication])
@permission_classes([IsAuthenticated])
class ExaminationResultView(APIView):

    def post(self, request):
        requested_insurances = ['insurance1', 'insurance2', 'insurance3']
        result = []
        data = request.data
        json_data = {
            'examination_appointment': data.get('examination_appointment'),
            'icd': data.get('icd'),
            'conclusion': data.get('conclusion'),
            'recommendations': data.get('recommendations'),
        }
        servers_to_query = {insurance: INSURANCES_TO_SERVERS[insurance] for insurance in requested_insurances if
                            insurance in INSURANCES_TO_SERVERS}
        for insurance, server in servers_to_query.items():
            headers = {'Authorization': f'Token {INSURANCES_TOKENS[insurance]}'}
            result = requests.post(f"{server}api/promedicine/examination/result/create", data=json_data, headers=headers)
            result.json()
        return Response(result)


class CustomerExaminationResultView(APIView):

    def get(self, request):
        iin = request.query_params.get('iin')
        requested_insurances = request.query_params.getlist('insurance')
        results = []

        servers_to_query = {insurance: INSURANCES_TO_SERVERS[insurance] for insurance in requested_insurances if
                            insurance in INSURANCES_TO_SERVERS}
        for insurance, server in servers_to_query.items():
            headers = {'Authorization': f'Token {INSURANCES_TOKENS[insurance]}'}
            response = requests.get(f"{server}api/promedicine/examination/result/{iin}", headers=headers)
            if response.status_code == 200:
                results.append(response.json())
            else:
                pass

        return Response(results, status=status.HTTP_200_OK)


class ScheduleCreateView(APIView):

    def post(self, request):
        doctor_code = request.data.get('doctor_code')
        start_datetime = request.data.get('start_datetime')
        customer_iin = request.data.get('customer_iin')
        requested_hospitals = ['hospital1']
        json_data = {
            'doctor_code': doctor_code,
            'start_datetime': start_datetime,
            'customer_iin': customer_iin
        }

        results = []

        # servers_to_query = {hospital: HOSPITALS_TO_SERVERS[hospital] for hospital in requested_hospitals if
        #                     hospital in HOSPITALS_TO_SERVERS}

        # for hospital, server in servers_to_query.items():
            # headers = {'Authorization': f'Token {HOSPITALS_TOKENS[hospital]}'}
            # response = requests.post(f"https://d33a-37-99-41-34.ngrok-free.app/api/register/schedule_create/", data=json_data)
            #
            # if response.status_code == 200:
            #     print("correcttttttttttttt")
            #     results.append(response.json())
            # else:
            #     print("errroooor")
            #     pass
        response = requests.post(f"http://82.200.165.222:1230/api/register/schedule_create/",
                                 data=json_data)

        if response.status_code == 200:
            results.append(response.json())
        else:
            pass
        return Response(results, status=status.HTTP_200_OK)


class PackageView(APIView):

    def get(self, request):
        iin = request.query_params.get('iin')
        requested_insurances = request.query_params.getlist('insurance')
        results = []

        servers_to_query = {insurance: INSURANCES_TO_SERVERS[insurance] for insurance in requested_insurances if
                            insurance in INSURANCES_TO_SERVERS}
        for insurance, server in servers_to_query.items():
            headers = {'Authorization': f'Token {INSURANCES_TOKENS[insurance]}'}
            response = requests.get(f"{server}api/promedicine/package/list/{iin}", headers=headers)
            if response.status_code == 200:
                results.append(response.json())
            else:
                pass

        return Response(results, status=status.HTTP_200_OK)
