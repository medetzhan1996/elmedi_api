# Generated by Django 4.0.6 on 2022-07-25 09:10

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    initial = True

    dependencies = [
        ('directory', '0005_rename_unicode_hospital_code'),
    ]

    operations = [
        migrations.CreateModel(
            name='Doctor',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('first_name', models.CharField(max_length=180)),
                ('last_name', models.CharField(max_length=180)),
                ('surname', models.CharField(max_length=180)),
                ('img', models.ImageField(upload_to='documents/')),
                ('hospital', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='directory.hospital')),
            ],
        ),
        migrations.CreateModel(
            name='Specialty',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('title', models.CharField(max_length=180)),
            ],
        ),
        migrations.CreateModel(
            name='DoctorTimetable',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('date', models.CharField(max_length=180)),
                ('time', models.CharField(max_length=180)),
                ('doctor', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='customer_personal_cabinet.doctor')),
            ],
        ),
        migrations.CreateModel(
            name='DoctorSpecialty',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('doctor', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='customer_personal_cabinet.doctor')),
                ('specialty', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='customer_personal_cabinet.specialty')),
            ],
        ),
        migrations.CreateModel(
            name='DoctorService',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('doctor', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='customer_personal_cabinet.doctor')),
                ('service', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='directory.service')),
            ],
        ),
    ]