from django.db import models
from mptt.models import MPTTModel, TreeForeignKey


# Базовый mixin
class BaseMixin(models.Model):
    title = models.CharField(max_length=320)

    def __str__(self):
        return self.title

    class Meta:
        abstract = True


# Услуги
class Service(BaseMixin, MPTTModel):
    code = models.CharField(max_length=180, null=True)
    parent = TreeForeignKey('self', on_delete=models.CASCADE, null=True,
                            blank=True, related_name='children')


# Страховая компания
class Insurance(BaseMixin):
    logo = models.ImageField(upload_to='documents/', blank=True, null=True)
    bin = models.CharField(max_length=180, null=True, blank=True)
    address = models.CharField(max_length=180, null=True, blank=True)
    iik = models.CharField(max_length=180, null=True, blank=True)
    bik = models.CharField(max_length=180, null=True, blank=True)
    phone_number = models.CharField(max_length=180, null=True, blank=True)
    residency = models.CharField(max_length=180, null=True, blank=True)
    sector_economy = models.CharField(max_length=180, null=True, blank=True)
    code = models.CharField(max_length=180, unique=True)


# Страховщик
class Insurer(BaseMixin):
    bin = models.CharField(max_length=180, null=True, blank=True)
    address = models.CharField(max_length=180, null=True, blank=True)
    iik = models.CharField(max_length=180, null=True, blank=True)
    bik = models.CharField(max_length=180, null=True, blank=True)
    phone_number = models.CharField(max_length=180, null=True, blank=True)
    residency = models.CharField(max_length=180, null=True, blank=True)
    sector_economy = models.CharField(max_length=180, null=True, blank=True)


# Больницы
class Hospital(BaseMixin):
    STATUS_CHOICES = (
        (0, "Сельская больница"),
        (1, "Районная больница"),
        (2, "Городская больница"),
    )
    logo = models.ImageField(upload_to='documents/', blank=True, null=True)
    address = models.CharField(max_length=180, null=True, blank=True)
    code = models.CharField(max_length=180, unique=True)
    status = models.IntegerField(choices=STATUS_CHOICES, default=0)

    def is_service_performed(self, service):
        return self.hospitalpackage_set.filter(
            hospitalpackageservice__service=service).exists()


# МКБ-10
class ICD(BaseMixin, MPTTModel):
    code = models.CharField(max_length=180, null=True, blank=True)
    parent = TreeForeignKey('self', on_delete=models.CASCADE, null=True,
                            blank=True, related_name='children')
    is_impossible = models.BooleanField(default=False)
