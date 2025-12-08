# README — Contatos (Flutter + SQLite)
---

## Requisitos (pré-instalação)

* **Flutter SDK** (stable). Instruções: [https://flutter.dev/docs/get-started/install](https://flutter.dev/docs/get-started/install)
* **Android Studio** (incluindo Android SDK, Android SDK Platform Tools e Android Emulator)
* **Java** (instalado com Android Studio normalmente)
* **Git** (opcional, para clonar repositório)
* **Dispositivo/Emulador Android** configurado (AVD Manager)

---


## Passo a passo — executar no Android Studio / emulador

1. **Clone ou copie o projeto**

```bash
git clone https://github.com/matheuspazesteves/Projeto-Integrador-V-A.git
cd Projeto-Integrador-V-A
```

ou apenas abra a pasta do projeto no Android Studio.

2. **Abra o projeto no Android Studio**

* File → Open → selecione a pasta do projeto (o diretório que contém `pubspec.yaml` e `lib/`).
* Android Studio vai detectar que é um projeto Flutter e perguntar para executar `flutter pub get`. Se não, rode manualmente:

```bash
flutter pub get
```


Depois execute `flutter pub get` novamente.

4. **Crie ou inicie um emulador Android (AVD)**

* Android Studio → Tools → Device Manager (ou AVD Manager) → Create Device → escolha um Pixel (ex.: Pixel 4) e uma System Image (API 31/32/33).
* Inicie o AVD (clique no ▶).

5. **Garanta que há um dispositivo disponível**
   No terminal do projeto:

```bash
flutter devices
```

Você verá algo como `emulator-5554 • Android SDK built for x86 • android-x86`.

6. **Limpe build anterior (opcional, recomendado)**

```bash
flutter clean
flutter pub get
```

7. **Execute o app no emulador**

```bash
flutter run -d emulator-5554
```

ou apenas:

```bash
flutter run
```

(se houver apenas um dispositivo/AVD disponível).

> Dica: para garantir que o entrypoint usado é `lib/main.dart`, rode:

```bash
flutter run -t lib/main.dart
```
