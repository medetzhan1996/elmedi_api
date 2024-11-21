# Generated by Django 4.0.6 on 2022-07-25 08:01

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('contenttypes', '0002_remove_content_type_name'),
        ('account', '0002_user_insurance'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='user',
            name='insurance',
        ),
        migrations.AddField(
            model_name='user',
            name='content_type',
            field=models.ForeignKey(default=1, limit_choices_to={'model__in': ('insurance', 'customer')}, on_delete=django.db.models.deletion.CASCADE, to='contenttypes.contenttype'),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='user',
            name='object_id',
            field=models.PositiveIntegerField(default=1),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='user',
            name='role',
            field=models.PositiveSmallIntegerField(choices=[(1, 'БАНК'), (2, 'КЛИЕНТ')], default=1),
        ),
    ]