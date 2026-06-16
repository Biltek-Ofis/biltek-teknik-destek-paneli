package tr.com.biltekbilgisayar.teknikservis

import android.printservice.PrintService
import android.printservice.PrinterDiscoverySession
import android.util.Log
import java.io.InputStream
import java.io.OutputStream
import java.net.Socket
import android.os.ParcelFileDescriptor
import android.printservice.PrintJob as ServicePrintJob

class NetworkPrintService : PrintService() {

    companion object {
        private const val TAG = "NetworkPrintService"

        // Tüm kayıtlı yazıcılar burada tutulur
        val printers = mutableListOf<PrinterConfig>()

        fun addOrUpdatePrinter(config: PrinterConfig) {
            val index = printers.indexOfFirst { it.id == config.id }
            if (index >= 0) printers[index] = config
            else printers.add(config)
        }

        fun removePrinter(id: String) {
            printers.removeAll { it.id == id }
        }

        fun clearPrinters() {
            printers.clear()
        }

        fun findPrinter(id: String): PrinterConfig? =
            printers.find { it.id == id }
    }

    override fun onCreatePrinterDiscoverySession(): PrinterDiscoverySession {
        // Her discovery başladığında SharedPreferences'tan taze yükle
        val saved = PrinterRepository.loadPrinters(applicationContext)
        Log.d(TAG, "onCreatePrinterDiscoverySession: ${saved.size} printer(s) loaded from SharedPreferences")
        saved.forEach { Log.d(TAG, "  → ${it.name} @ ${it.ip}:${it.port}") }
        printers.clear()
        printers.addAll(saved)
        return NetworkPrinterDiscoverySession(this)
    }

    override fun onRequestCancelPrintJob(printJob: ServicePrintJob) {
        Log.d(TAG, "Cancel requested: ${printJob.id}")
        printJob.cancel()
    }

    override fun onPrintJobQueued(printJob: ServicePrintJob) {
        Log.d(TAG, "Job queued: ${printJob.id}")

        val printerId = printJob.info.printerId?.localId ?: run {
            printJob.fail("Yazıcı ID alınamadı")
            return
        }

        val config = findPrinter(printerId)
        if (config == null) {
            Log.e(TAG, "Printer not found: $printerId")
            printJob.fail("Yazıcı bulunamadı")
            return
        }

        Thread {
            try {
                val data = printJob.document.data
                if (data == null) {
                    printJob.fail("Yazdırılacak veri yok")
                    return@Thread
                }

                val inputStream: InputStream =
                    ParcelFileDescriptor.AutoCloseInputStream(data)
                val socket = Socket(config.ip, config.port)
                val outputStream: OutputStream = socket.getOutputStream()

                val buffer = ByteArray(4096)
                var bytesRead: Int
                while (inputStream.read(buffer).also { bytesRead = it } != -1) {
                    outputStream.write(buffer, 0, bytesRead)
                }

                outputStream.flush()
                socket.close()
                inputStream.close()

                printJob.complete()
                Log.d(TAG, "Job completed → ${config.name} @ ${config.ip}")

            } catch (e: Exception) {
                Log.e(TAG, "Job failed: ${e.message}", e)
                printJob.fail("Yazdırma hatası: ${e.message}")
            }
        }.start()
    }
}