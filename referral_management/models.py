import datetime
from django.db import models
from elmedi_api.constants import TYPE_APPEAL_CHOICES, PLACE_CHOICES
from customer_management.models import Customer, CustomerInsurance
from directory.models import Service, Hospital, ICD


# Направление пациента
class Referral(models.Model):
    STATUS_CHOICES = (
        (0, "Не выполнена"),
        (1, "Выполнена"),
    )
    customer = models.ForeignKey(Customer, on_delete=models.CASCADE)
    sending_hospital = models.ForeignKey(Hospital, on_delete=models.CASCADE,
                                         related_name='sending_hospital')
    directed_hospital = models.ForeignKey(Hospital, on_delete=models.CASCADE,
                                          related_name='directed_hospital')
    type_appeal = models.IntegerField(choices=TYPE_APPEAL_CHOICES)
    place = models.IntegerField(choices=PLACE_CHOICES)
    service = models.ForeignKey(
        Service, on_delete=models.CASCADE, related_name='referral_services')
    doctor_full_name = models.CharField(max_length=180, blank=True, null=True)
    performing_doctor = models.CharField(max_length=180, blank=True, null=True)
    date = models.DateField(default=datetime.date.today)
    cancel_date = models.DateField(blank=True, null=True)
    icd = models.ForeignKey(ICD, on_delete=models.CASCADE, blank=True, null=True)
    customer_insurance = models.ForeignKey(CustomerInsurance, on_delete=models.CASCADE)
    status = models.IntegerField(choices=STATUS_CHOICES, default=0)
    time = models.TimeField(null=True, blank=True)
    is_saved = models.BooleanField(default=False)
