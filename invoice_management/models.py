from django.db import models
from directory.models import Service, ICD
from elmedi_api.constants import TYPE_APPEAL_CHOICES, PLACE_CHOICES
from customer_management.models import CustomerInsurance
from referral_management.models import Referral
from directory.models import Hospital
from customer_management.models import Customer


# Счет реестр пациента
class Invoice(models.Model):
    customer = models.ForeignKey(Customer, on_delete=models.CASCADE)
    service = models.ForeignKey(Service, on_delete=models.CASCADE)
    icd = models.ForeignKey(ICD, on_delete=models.CASCADE)
    customer_insurance = models.ForeignKey(CustomerInsurance, on_delete=models.CASCADE)
    referral = models.ForeignKey(Referral, on_delete=models.CASCADE, null=True, blank=True)
    hospital = models.ForeignKey(Hospital, on_delete=models.CASCADE)
    consumption = models.DecimalField(
        max_digits=10, decimal_places=0, default=0)
    performing_doctor = models.CharField(max_length=180, blank=True, null=True)
    doctor_signature = models.TextField(blank=True, null=True)
    date = models.DateField(auto_now_add=True)
    type_appeal = models.IntegerField(choices=TYPE_APPEAL_CHOICES)
    place = models.IntegerField(choices=PLACE_CHOICES)
    screen_title = models.CharField(max_length=180, blank=True, null=True)
    screen = models.TextField(blank=True, null=True)

