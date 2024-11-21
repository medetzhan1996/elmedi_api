from django.db import models
from directory.models import Service, Hospital


# Доктор
class Specialty(models.Model):
    title = models.CharField(max_length=180)


# Доктор
class Doctor(models.Model):
    first_name = models.CharField(max_length=180)
    last_name = models.CharField(max_length=180)
    surname = models.CharField(max_length=180)
    hospital = models.ForeignKey(Hospital, on_delete=models.CASCADE)
    img = models.ImageField(upload_to='documents/')
    services = models.ManyToManyField(Service)
    code = models.CharField(max_length=180, null=True)

    @property
    def full_name(self):
        return "{} {} {}".format(
            self.last_name, self.first_name, self.surname)

    def __str__(self):
        return "ФИО: {} {}".format(
            self.last_name, self.first_name)


class DoctorSpecialty(models.Model):
    doctor = models.ForeignKey(Doctor, on_delete=models.CASCADE)
    specialty = models.ForeignKey(Specialty, on_delete=models.CASCADE)


# Доктор
class DoctorService(models.Model):
    doctor = models.ForeignKey(Doctor, on_delete=models.CASCADE)
    service = models.ForeignKey(Service, on_delete=models.CASCADE)


# Доктор
class DoctorTimetable(models.Model):
    doctor = models.ForeignKey(Doctor, on_delete=models.CASCADE)
    date = models.DateField()
    time = models.TimeField()


# Доктор
class DoctorOutsideTimetable(models.Model):
    WEEK_CHOICES = (
        (0, "ПН"),
        (1, "ВТ"),
        (2, "СР"),
        (3, "ЧТ"),
        (4, "ПТ"),
        (5, "СБ"),
        (6, "ВС"),
    )
    doctor = models.ForeignKey(Doctor, on_delete=models.CASCADE)
    start_time = models.TimeField()
    end_time = models.TimeField()
    week = models.IntegerField(choices=WEEK_CHOICES, default=0)


class PayProgram(models.Model):
    contract = models.CharField(max_length=180)
    program = models.CharField(max_length=180)
    iin = models.CharField(max_length=180)