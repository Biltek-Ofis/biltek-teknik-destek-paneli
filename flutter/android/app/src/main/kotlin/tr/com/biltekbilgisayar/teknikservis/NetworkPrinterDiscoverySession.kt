package tr.com.biltekbilgisayar.teknikservis

import android.print.PrintAttributes
import android.print.PrinterCapabilitiesInfo
import android.print.PrinterId
import android.print.PrinterInfo
import android.printservice.PrintService
import android.printservice.PrinterDiscoverySession
import android.util.Log

class NetworkPrinterDiscoverySession(
    private val service: PrintService
) : PrinterDiscoverySession() {

    companion object {
        private const val TAG = "PrinterDiscovery"
    }

    override fun onStartPrinterDiscovery(priorityList: MutableList<PrinterId>) {
        Log.d(TAG, "Discovery started, ${NetworkPrintService.printers.size} printer(s)")
        refreshPrinters()
    }

    override fun onStopPrinterDiscovery() {
        Log.d(TAG, "Discovery stopped")
    }

    override fun onValidatePrinters(printerIds: MutableList<PrinterId>) {
        // İsteğe bağlı: hâlâ erişilebilir mi diye kontrol eklenebilir
    }

    override fun onStartPrinterStateTracking(printerId: PrinterId) {}
    override fun onStopPrinterStateTracking(printerId: PrinterId) {}
    override fun onDestroy() {}

    fun refreshPrinters() {
        Log.d(TAG, "refreshPrinters: ${NetworkPrintService.printers.size} printer(s) in list")
        val printerInfoList = NetworkPrintService.printers.mapNotNull { config ->
            val printerId: PrinterId = service.generatePrinterId(config.id) 
                ?: return@mapNotNull null

            val capabilities = PrinterCapabilitiesInfo.Builder(printerId)
                .setMinMargins(PrintAttributes.Margins.NO_MARGINS)
                .setColorModes(
                    PrintAttributes.COLOR_MODE_COLOR or PrintAttributes.COLOR_MODE_MONOCHROME,
                    PrintAttributes.COLOR_MODE_COLOR  // default: color
                )
                .addMediaSize(PrintAttributes.MediaSize.ISO_A4, true)
                .addResolution(
                    PrintAttributes.Resolution("res_300", "300dpi", 300, 300),
                    true
                )
                .build()

            PrinterInfo.Builder(
                printerId,
                config.name,
                PrinterInfo.STATUS_IDLE
            )
                .setCapabilities(capabilities)
                .build()
        }

        if (printerInfoList.isNotEmpty()) {
            addPrinters(printerInfoList)
            Log.d(TAG, "Added ${printerInfoList.size} printer(s)")
        }
    }
}