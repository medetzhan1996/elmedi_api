from django.db import models
from django.contrib.auth.models import AbstractUser
from directory.models import Insurance, Hospital
from customer_management.models import Customer


class User(AbstractUser):
    USER_ROLE_CHOICES = (
        (1, 'БАНК'),
        (2, 'КЛИЕНТ'),
        (3, 'Отчет'),
    )
    insurance = models.ForeignKey(Insurance, on_delete=models.CASCADE, null=True, blank=True)
    customer = models.ForeignKey(Customer, on_delete=models.CASCADE, null=True, blank=True)
    hospital = models.ForeignKey(Hospital, on_delete=models.CASCADE, null=True, blank=True)
    role = models.PositiveSmallIntegerField(choices=USER_ROLE_CHOICES, default=1)
