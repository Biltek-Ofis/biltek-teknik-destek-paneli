package tr.com.biltekbilgisayar.teknikservis

import android.os.Bundle
import io.flutter.embedding.android.FlutterActivity
import io.flutter.embedding.engine.FlutterEngine
import io.flutter.plugin.common.MethodChannel
import org.json.JSONArray

class PrinterSettingsActivity : FlutterActivity() {

    companion object {
        private const val CHANNEL = "biltekteknikservis/printer"
    }

    override fun configureFlutterEngine(flutterEngine: FlutterEngine) {
        super.configureFlutterEngine(flutterEngine)

        MethodChannel(flutterEngine.dartExecutor.binaryMessenger, CHANNEL)
            .setMethodCallHandler { call, result ->
                when (call.method) {
                    "getInitialRoute" -> result.success("yazici_ayarlari")

                    "registerPrinter" -> {
                        val ip = call.argument<String>("ip")
                        val port = call.argument<Int>("port") ?: 9100
                        val name = call.argument<String>("name") ?: "Yazıcı"
                        if (ip.isNullOrBlank()) {
                            result.error("INVALID_IP", "IP boş olamaz", null)
                            return@setMethodCallHandler
                        }
                        val config = PrinterConfig(id = "$ip:$port", ip = ip, port = port, name = name)
                        NetworkPrintService.addOrUpdatePrinter(config)
                        // SharedPreferences'a da kaydet
                        PrinterRepository.savePrinters(applicationContext, NetworkPrintService.printers)
                        result.success(true)
                    }

                    "registerAllPrinters" -> {
                        val jsonStr = call.argument<String>("printers") ?: "[]"
                        val jsonArray = JSONArray(jsonStr)
                        NetworkPrintService.clearPrinters()
                        for (i in 0 until jsonArray.length()) {
                            NetworkPrintService.addOrUpdatePrinter(PrinterConfig.fromJson(jsonArray.getJSONObject(i)))
                        }
                        // SharedPreferences'a da kaydet
                        PrinterRepository.savePrinters(applicationContext, NetworkPrintService.printers)
                        result.success(true)
                    }

                    "removePrinter" -> {
                        val id = call.argument<String>("id")
                        if (id != null) {
                            NetworkPrintService.removePrinter(id)
                            // SharedPreferences'ı da güncelle
                            PrinterRepository.savePrinters(applicationContext, NetworkPrintService.printers)
                        }
                        result.success(true)
                    }

                    "clearPrinters" -> {
                        NetworkPrintService.clearPrinters()
                        // SharedPreferences'ı da temizle
                        PrinterRepository.savePrinters(applicationContext, emptyList())
                        result.success(true)
                    }

                    "getPrinters" -> {
                        // companion object boş olabilir, SharedPreferences'tan oku
                        val saved = PrinterRepository.loadPrinters(applicationContext)
                        // companion object'i de güncelle
                        NetworkPrintService.clearPrinters()
                        saved.forEach { NetworkPrintService.addOrUpdatePrinter(it) }
                        
                        val arr = JSONArray()
                        saved.forEach { arr.put(it.toJson()) }
                        result.success(arr.toString())
                    }

                    "openPrintSettings" -> {
                        result.success(true)
                    }

                    else -> result.notImplemented()
                }
            }
    }
}