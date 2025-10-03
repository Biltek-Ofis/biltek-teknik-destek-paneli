package tr.com.biltekbilgisayar.teknikservis

import android.content.Intent
import android.os.Bundle
import io.flutter.embedding.android.FlutterActivity
import io.flutter.embedding.engine.FlutterEngine
import io.flutter.plugin.common.MethodChannel

class MainActivity : FlutterActivity(){
    private val CHANNEL = "teknikservis/notifications"
    private var methodChannel: MethodChannel? = null
    private var pendingNotificationData: Map<String, String?>? = null

    override fun configureFlutterEngine(flutterEngine: FlutterEngine) {
        super.configureFlutterEngine(flutterEngine)
        methodChannel = MethodChannel(flutterEngine.dartExecutor.binaryMessenger, CHANNEL)
        pendingNotificationData?.let {
            methodChannel?.invokeMethod("notificationClicked", it)
            pendingNotificationData = null
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        handleIntent(intent)
    }

    override fun onNewIntent(intent: Intent) {
        super.onNewIntent(intent)
        setIntent(intent)
        handleIntent(intent)
    }

    private fun handleIntent(intent: Intent) {
        val tip = intent.getStringExtra("tip")
        val id = intent.getStringExtra("id")
        if (tip != null) {
            // FlutterEngine hazır değilse intent'i sakla
            val data = mapOf("tip" to tip, "id" to id)
            if (methodChannel != null) {
                methodChannel?.invokeMethod("notificationClicked", data)
            } else {
                // FlutterEngine hazır olunca çağırılacak şekilde sakla
                pendingNotificationData = data
            }
        }
    }
}
